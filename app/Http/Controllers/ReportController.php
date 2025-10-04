<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $userRepository;
    protected $collectionRepository;
    protected $reportService;

    public function __construct(
        \App\Repositories\UserRepositoryInterface $userRepository,
        \App\Repositories\CollectionRepositoryInterface $collectionRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->collectionRepository = $collectionRepository;
    }

    public function index()
    {
        $userId = Auth::id();

        // Estadísticas básicas (puede devolver counts, etc.)
        $statistics = $this->userRepository->getStatistics($userId) ?? [];

        // Datos mensuales y próximas recolecciones
        $currentYear = now()->year;
        $monthlyStats = $this->collectionRepository->getMonthlyStats($userId, $currentYear);
        $upcomingCollections = $this->collectionRepository->getUpcoming($userId);

        // --- CALCULAR total_weight_recycled de forma segura ---
        // Intentamos usar la estadística si existe, si no calculamos a partir de las colecciones
        if (isset($statistics['total_weight_recycled'])) {
            $totalWeightRecycled = (float) $statistics['total_weight_recycled'];
        } else {
            // Obtener todas las colecciones del usuario y sumar weights (preferir actual_weight)
            $cols = $this->collectionRepository->getUserCollections($userId);

            // Si getUserCollections devuelve una Collection de Eloquent o Collection de objetos
            $totalWeightRecycled = 0.0;
            if ($cols) {
                // sumar actual_weight cuando exista, si no tomar estimated_weight
                foreach ($cols as $c) {
                    // convierto a float seguro
                    $aw = isset($c->actual_weight) ? (float)$c->actual_weight : null;
                    $ew = isset($c->estimated_weight) ? (float)$c->estimated_weight : 0.0;

                    // Si actual_weight es > 0 lo uso, si no, uso estimated_weight
                    $totalWeightRecycled += ($aw && $aw > 0) ? $aw : $ew;
                }
            }
        }

        // Evitar NaN / null
        $totalWeightRecycled = $totalWeightRecycled ?: 0.0;

        // Calcular impacto ambiental (ejemplo de fórmulas)
        $environmentalImpact = [
            'co2_saved' => round($totalWeightRecycled * 0.7, 2),           // kg CO2 estimado
            'trees_equivalent' => (int) round($totalWeightRecycled / 15), // árboles equivalentes
            'energy_saved' => round($totalWeightRecycled * 2.5, 2),       // kWh estimado
            'total_weight_recycled' => round($totalWeightRecycled, 2),
        ];

        return view('reports.index', compact('statistics', 'monthlyStats', 'upcomingCollections', 'environmentalImpact'));
    }

    public function exportPDF()
    {
        $userId = auth()->id();

        // Si tienes ReportService, úsalo; si no, reconstruimos datos similares al index()
        if (isset($this->reportService)) {
            $data = $this->reportService->generate($userId);
        } else {
            // generación básica para PDF (similar a index)
            $statistics = $this->userRepository->getStatistics($userId) ?? [];
            $currentYear = now()->year;
            $monthlyStats = $this->collectionRepository->getMonthlyStats($userId, $currentYear);
            $cols = $this->collectionRepository->getUserCollections($userId);

            $totalWeight = 0;
            foreach ($cols as $c) {
                $aw = isset($c->actual_weight) ? (float)$c->actual_weight : null;
                $ew = isset($c->estimated_weight) ? (float)$c->estimated_weight : 0.0;
                $totalWeight += ($aw && $aw > 0) ? $aw : $ew;
            }

            $environmentalImpact = [
                'co2_saved' => round($totalWeight * 0.7, 2),
                'trees_equivalent' => (int) round($totalWeight / 15),
                'energy_saved' => round($totalWeight * 2.5, 2),
                'total_weight_recycled' => round($totalWeight, 2),
            ];

            $data = [
                'statistics' => $statistics,
                'monthly_data' => $monthlyStats,
                'environmental_impact' => $environmentalImpact,
                'generated_at' => now()->toDateTimeString(),
            ];
        }

        // carga la vista PDF (resources/views/reports/pdf.blade.php)
        $pdf = Pdf::loadView('reports.pdf', ['data' => $data]);

        $filename = 'reporte_usuario_' . $userId . '.pdf';
        return $pdf->download($filename);
    }
}
