<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trainer\StoreTrainerRequest;
use App\Http\Requests\Trainer\UpdateTrainerRequest;
use App\Services\TrainerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function __construct(
        private TrainerService $trainerService
    ) {}

    public function index(): View
    {
        $trainers = $this->trainerService->getAllTrainers();
        return view('trainers.index', compact('trainers'));
    }

    public function create(): View
    {
        return view('trainers.create');
    }

    public function store(StoreTrainerRequest $request): RedirectResponse
    {
        $trainer = $this->trainerService->createTrainer($request->validated());
        return redirect()->route('trainers.index')->with('success', 'Trainer created successfully.');
    }

    public function show($id): View
    {
        $trainer = $this->trainerService->getTrainerById($id);
        return view('trainers.show', compact('trainer'));
    }

    public function edit($id): View
    {
        $trainer = $this->trainerService->getTrainerById($id);
        return view('trainers.edit', compact('trainer'));
    }

    public function update(UpdateTrainerRequest $request, $id): RedirectResponse
    {
        $this->trainerService->updateTrainer($id, $request->validated());
        return redirect()->route('trainers.index')->with('success', 'Trainer updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->trainerService->deleteTrainer($id);
        return redirect()->route('trainers.index')->with('success', 'Trainer deleted successfully.');
    }
}
