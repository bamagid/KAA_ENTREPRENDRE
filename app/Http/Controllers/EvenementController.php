<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Secteur;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    public function index()
    {
        
        $events = Evenement::where('is_deleted', false)->get();
        return response()->json($events, 200);
    }

    public function show($id)
    {
        
        $event = Evenement::findOrFail($id);
        return response()->json($event, 200);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
    
        $request->validate([
            'nomEvenement' => 'required|string',
            'type' => 'required|in:en ligne,presentiel',
            'dateEvenement' => 'required|date',
            'lieuEvenement' => 'required|string',
            'description' => 'required|string',
            'secteur_id' => 'required|exists:secteurs,id',
        ]);
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
    
    
       
        $event = Evenement::create([
            'nomEvenement' => $request->nomEvenement,
            'type' => $request->type,
            'dateEvenement' => $request->dateEvenement,
            'lieuEvenement' => $request->lieuEvenement,
            'image'=>$imagePath,
            'description' => $request->description,
            'user_id' => $user->id,
            'secteur_id' => $request->secteur_id,
        ]);
    
        return response()->json(['message' => 'Evenement created successfully', 'event' => $event], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomEvenement' => 'required|string',
            'type' => 'required|in:en ligne,presentiel',
            'dateEvenement' => 'required|date',
            'lieuEvenement' => 'required|string',
            'description' => 'required|string',
            'secteur_id' => 'required|exists:secteurs,id',
        ]);
    

        $event = Evenement::find($id);
    

        if (!$event) {
            return response()->json(['message' => 'Evenement not found'], 404);
        }
    
        $user = auth()->user();
        $imagePath = $event->image; // Utilisez l'image existante par défaut
    
        if ($request->hasFile('image')) {
          
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }

        $event->update([
            'nomEvenement' => $request->nomEvenement,
            'type' => $request->type,
            'dateEvenement' => $request->dateEvenement,
            'lieuEvenement' => $request->lieuEvenement,
            'image' => $imagePath,
            'description' => $request->description,
            'user_id' => $user->id,
            'secteur_id' => $request->secteur_id,
        ]);
    
        return response()->json(['message' => 'Evenement updated successfully', 'event' => $event], 200);
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $event = Evenement::findOrFail($id);
        if (!$event) {
            return response()->json(['message' => 'Evenement not found'], 404);
        }
    
        $event->delete();
    
        return response()->json(['message' => 'Evenement supprime avec succès'], 200);
    }
}

