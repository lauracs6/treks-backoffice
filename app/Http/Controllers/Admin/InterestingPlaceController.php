<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterestingPlace;
use App\Models\PlaceType;
use Illuminate\Http\Request;

class InterestingPlaceController extends Controller
{
    // Listado con búsqueda y filtro por tipo
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $type = $request->query('type', 'all');
        $status = $request->query('status', 'all');

        $types = PlaceType::query()
            ->orderBy('name')
            ->get();

        $places = InterestingPlace::query()
            ->with('placeType')

            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('gps', 'like', "%{$search}%");
                });
            })

            ->when($type !== 'all', function ($query) use ($type) {
                $query->where('place_type_id', $type);
            })
            
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status === 'active' ? 'y' : 'n');
            })

            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.places.index', [
            'places' => $places,
            'search' => $search,
            'type' => $type,
            'types' => $types,
            'status' => $status,
        ]);
    }

    // Show de un lugar con paginación
    public function show(InterestingPlace $adminPlace)
    {
        $place = $adminPlace->load([
            'placeType',
            'treks' => fn ($query) => $query
                ->with('municipality')
                ->orderBy('regnumber'),
        ]);

        $previous = InterestingPlace::where('id', '<', $place->id)
            ->orderBy('id', 'desc')
            ->first();

        $next = InterestingPlace::where('id', '>', $place->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('admin.places.show', [
            'place' => $place,
            'previous' => $previous,
            'next' => $next,
        ]);
    }


    // Formulario de creación
    public function create()
    {
        $types = PlaceType::query()->orderBy('name')->get();

        return view('admin.places.create', [
            'place' => new InterestingPlace(),
            'types' => $types,
        ]);
    }

    // Guarda un lugar nuevo
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'place_type_id' => ['required', 'exists:place_types,id'],
        ]);

        $gps = number_format((float) $data['latitude'], 6, '.', '')
            . ',' . number_format((float) $data['longitude'], 6, '.', '');
        $exists = InterestingPlace::query()->where('gps', $gps)->exists();
        if ($exists) {
            return back()
                ->withErrors(['latitude' => 'Las coordenadas ya existen.'])
                ->withInput();
        }

        InterestingPlace::create([
            'name' => $data['name'],
            'gps' => $gps,
            'place_type_id' => (int) $data['place_type_id'],
        ]);

        return redirect()
            ->route('admin.places.index')
            ->with('status', 'Place created.');
    }

    
    // Formulario de edición
    public function edit(InterestingPlace $adminPlace)
    {
        $types = PlaceType::query()->orderBy('name')->get();

        return view('admin.places.edit', [
            'place' => $adminPlace->load('placeType'),
            'types' => $types,
        ]);
    }

    // Actualiza un lugar existente
    public function update(Request $request, InterestingPlace $adminPlace)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'place_type_id' => ['required', 'exists:place_types,id'],
        ]);

        $gps = number_format((float) $data['latitude'], 6, '.', '')
            . ',' . number_format((float) $data['longitude'], 6, '.', '');
        $exists = InterestingPlace::query()
            ->where('gps', $gps)
            ->where('id', '!=', $adminPlace->id)
            ->exists();
        if ($exists) {
            return back()
                ->withErrors(['latitude' => 'Coordenates in use.'])
                ->withInput();
        }

        $adminPlace->update([
            'name' => $data['name'],
            'gps' => $gps,
            'place_type_id' => (int) $data['place_type_id'],
        ]);

        return redirect()
            ->route('admin.places.edit', $adminPlace)
            ->with('status', 'Place updated.');
    }

    // Desactiva el lugar en lugar de eliminarlo
    public function deactivate(InterestingPlace $adminPlace)
    {
        $adminPlace->update(['status' => 'n']);

        return redirect()
            ->route('admin.places.index')
            ->with('status', 'Place deactivated.');
    }

    // Reactivar
    public function activate(InterestingPlace $adminPlace)
    {
        $adminPlace->update(['status' => 'y']);

        return redirect()
            ->route('admin.places.index')
            ->with('status', 'Place activated.');
    }

    public function destroy(InterestingPlace $adminPlace)
    {
        // Revisar si tiene relaciones
        $hasTreks = $adminPlace->treks()->exists();
        $hasComments = method_exists($adminPlace, 'comments') && $adminPlace->comments()->exists();

        if ($hasTreks || $hasComments) {
            return redirect()
                ->route('admin.places.index')
                ->with('error', 'Cant be deleted due to its existing relations.');
        }

        // Si no tiene relaciones, se puede eliminar
        $adminPlace->delete();

        return redirect()
            ->route('admin.places.index')
            ->with('status', 'Place deleted.');
    }


}
