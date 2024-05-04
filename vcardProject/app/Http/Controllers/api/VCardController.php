<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VCardController extends Controller
{
     /**
     * View to import the file
     * @return \Illuminate\View\View
     */
    public function view_create()
    {
        return view('create');
    }

    /**
     * View to list the contacts
     * @return \Illuminate\View\View
     */
    public function view_contacts()
    {
        $contacts = Contact::all();
        return view('visualize', ['contacts' => $contacts]);
    }

    //Function to manipulate the file
    public function store(Request $request)
    {
        $request->validate([
            'vcard' => 'required|file'
        ]);
    
        $file = $request->file('vcard');
        $vcardData = fopen($file->getPathname(), 'r');
    
        $splitter = new \Sabre\VObject\Splitter\VCard($vcardData);
    
        try {
            while ($vcard = $splitter->getNext()) {
                Contact::create([
                    'full_name' => (string) $vcard->FN,
                    'telephone' => (string) $vcard->TEL,
                    'email' => (string) $vcard->EMAIL,
                    'organization' => (string) $vcard->ORG,
                    'title' => (string) $vcard->TITLE,
                    'url' => (string) $vcard->URL,
                    'address' => (string) $vcard->ADR,
                    'note' => (string) $vcard->NOTE,
                ]);
            }
            Log::info("Contacts import with sucess");
        } catch (\Exception $e) {
            Log::info("Error importing contacts");
            return back()->with('error', 'Erro ao processar o arquivo vCard: ' . $e->getMessage());
        } finally {
            fclose($vcardData);
        }
    
        return back()->with('success', 'Contatos importados com sucesso!');
    }

    /**
     * @OA\Get(
     *     tags={"Contacts"},
     *     summary="Get all Contacts",
     *     description="This endpoint returns a array of Contacts.",
     *     path="/api/contacts",
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="full_name", type="string", example="Value"),
     *                     @OA\Property(property="telephone", type="date", example="Value"),
     *                     @OA\Property(property="email", type="date", example="Value"),
     *                     @OA\Property(property="organization", type="date", example="Value"),
     *                     @OA\Property(property="title", type="date", example="Value"),
     *                     @OA\Property(property="url", type="date", example="Value"),
     *                     @OA\Property(property="address", type="date", example="Value"),
     *                     @OA\Property(property="note", type="date", example="Value")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllContacts()
    {
        $contacts = Contact::all();
        $contacts->makeHidden(["created_at", "updated_at"]);
        Log::info("Contacts returned with sucess ", ["contacts" => $contacts->toArray()]);
        return response()->json($contacts, 200);
    }
}
