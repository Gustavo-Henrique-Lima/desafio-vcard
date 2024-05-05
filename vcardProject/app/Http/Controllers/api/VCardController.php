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

                //Regex to format the address
                $address = preg_replace('/[\/\\\\]/', '', (string) $vcard->ADR);
                $address = preg_replace('/;+/', ', ', $address);

                if (strpos($address, ',') === 0) {
                    $address = substr($address, 1);
                }

                $formatted_address = preg_replace('/(\\d)([A-Za-z])/', '$1 $2', $address);

                //Regex to format the organization
                $organization = preg_replace('/[;,\/\\\\]/', '', (string) $vcard->ORG);
                $formatted_organization = preg_replace('/(\\d)([A-Za-z])/', '$1 $2', $organization); // Adiciona espaço entre número e letra
        
                //Regex to format phoneNumber
                $digits = preg_replace('/\D/', '', (string) $vcard->TEL);
                $phoneNumber = '(' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 5) . '-' . substr($digits, 8);

                Contact::create([
                    'full_name' => (string) $vcard->FN,
                    'telephone' => $phoneNumber,
                    'email' => (string) $vcard->EMAIL,
                    'organization' => $formatted_organization,
                    'title' => (string) $vcard->TITLE,
                    'url' => (string) $vcard->URL,
                    'address' => $formatted_address,
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
