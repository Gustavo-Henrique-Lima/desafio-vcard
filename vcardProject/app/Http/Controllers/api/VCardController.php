<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VCardController extends Controller
{
     /**
     * View para importar o arquivo
     * @return \Illuminate\View\View
     */
    public function view_create()
    {
        return view('create');
    }

    /**
     *View para listar os contatos
     * @return \Illuminate\View\View
     */
    public function view_contacts()
    {
        $contacts = Contact::all();
        return view('visualize', ['contacts' => $contacts]);
    }

    //Função para manipular o arquivo
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

    //API
    public function getAllContacts()
    {
        $contacts = Contact::all();
        $contacts->makeHidden(["created_at", "updated_at"]);
        Log::info("Contacts returned with sucess ", ["contacts" => $contacts->toArray()]);
        return response()->json($contacts, 200);
    }
}
