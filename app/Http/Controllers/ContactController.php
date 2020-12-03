<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Phone;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function filter($contacts, $request, &$sort, &$search)
    {
        if ($request->categories) {
            foreach ($request->categories as $cat) {
                if ($cat == 'individual') {
                    $contacts = $contacts->where('category', 'Физическое лицо');
                }
                if ($cat == 'entity') {
                    $contacts = $contacts->where('category', 'Юридическое лицо');
                }
            }
        }
        if ($request->sort == 'name') {
            $contacts = $contacts->orderBy('name', 'asc');
            $sort = 'name';
        } else {
            $contacts = $contacts->orderBy('created_at', 'desc');
            $sort = 'date';
        }
        if ($request->q) {
            $search = $request->q;
            $contacts = $contacts->where('name', 'like', '%' . $request->q . '%');
        }
    }

    public function index(Request $request, $pub = '')
    {
        $cats = $request->categories ? $request->categories : [];
        $sort = null;
        $search = null;
        info($request->categories);
        if ($pub == 'my') {
            if (Auth::check()) {
                $contacts = $request->user()->contacts();
                $this->filter($contacts, $request, $sort, $search);
            } else {
                return redirect()->route('login');
            }
        } else {
            $contacts = Contact::where('isPublic', $pub != 'my');
            $this->filter($contacts, $request, $sort, $search);
        }
        $contacts = $contacts->paginate(5);
        return view('contacts.index', compact('contacts', 'pub', 'cats', 'sort', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create', [
            'contact' => null,
            'numbers' => null,
            'countries' => null,
            'towns' => null,
            'adresses' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'photo' => 'image'
        ]);

        $contact = Contact::create($request->except('nums', 'locs', 'photo'));
        if ($request->photo) {
            $contact->photo = $request->file('photo')->store('uploads', 'public');
        }

        if (!$request->user()->isAdmin) {
            $contact->users()->attach($request->user());
        } else {
            $contact->isPublic = true;
        }

        $contact->save();

        if ($request->nums)
            foreach ($request->nums as $num) {
                Phone::create([
                    'number' => $num,
                    'contact_id' => $contact->id
                ]);
            }

        $locations = json_decode($request->locs);
        if (isset($locations))
            for ($i = 0, $n = count($locations); $i < $n; $i++) {
                Location::create([
                    'country' => $locations[$i]->country,
                    'town' => $locations[$i]->town,
                    'address' => $locations[$i]->address,
                    'contact_id' => $contact->id
                ]);
            }

        return redirect()->route('contact.index', ['pub' => !$request->user()->isAdmin ? 'my' : '']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $numbers = $contact->phones()->pluck('number');
        $locations = json_encode($contact->locations);
        return view('contacts.edit', compact('contact', 'numbers', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'photo' => 'image'
        ]);

        $contact->update($request->except('nums', 'locs'));
        if ($request->photo) {
            if ($contact->photo) Storage::disk('public')->delete($contact->photo);
            $contact->photo = $request->file('photo')->store('uploads', 'public');
            $contact->save();
        }

        if ($request->nums) {
            $contacts = $contact->phones()->get();
            $n = $countNums = count($request->nums);
            $m = $countPhones = count($contacts);
            $flag = true;
            if ($countNums < $countPhones) {
                $n = $countPhones;
                $m = $countNums;
                $flag = false;
            }
            for ($i = 0; $i < $n; $i++) {
                if ($i < $m) {
                    $contacts[$i]->update([
                        'number' => $request->nums[$i]
                    ]);
                } else {
                    if ($flag) {
                        Phone::create([
                            'number' => $request->nums[$i],
                            'contact_id' => $contact->id
                        ]);
                    } else {
                        $contacts[$i]->delete();
                    }
                }
            }
        }

        $locs = json_decode($request->locs);
        if (isset($locs)) {
            $locations = $contact->locations;
            $n = $countLocs = count($locs);
            $m = $countLocations = count($locations);
            $flag = true;
            if ($countLocs < $countLocations) {
                $n = $countLocations;
                $m = $countLocs;
                $flag = false;
            }
            for ($i = 0; $i < $n; $i++) {
                if ($i < $m) {
                    $locations[$i]->update([
                        'country' => $locs[$i]->country,
                        'town' => $locs[$i]->town,
                        'address' => $locs[$i]->address,
                    ]);
                } else {
                    if ($flag) {
                        Location::create([
                            'country' => $locs[$i]->country,
                            'town' => $locs[$i]->town,
                            'address' => $locs[$i]->address,
                            'contact_id' => $contact->id
                        ]);
                    } else {
                        $locations[$i]->delete();
                    }
                }
            }
        }
        return redirect()->route('contact.index', ['pub' => !$request->user()->isAdmin ? 'my' : '']);
    }

    public function add(Contact $contact, Request $request)
    {
        if ($contact->isPublic) $contact->users()->attach($request->user());
        return redirect()->route('contact.index');
    }

    public function delete(Contact $contact, Request $request)
    {
        if ($contact->isPublic) $contact->users()->detach($request->user());
        return redirect()->route('contact.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact, Request $request)
    {
        if ($contact->photo) Storage::disk('public')->delete($contact->photo);
        $contact->delete();
        return redirect()->route('contact.index', ['pub' => !$request->user()->isAdmin ? 'my' : '']);
    }
}
