<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{

    use WithPagination;

    /**
     * Used to search in all the users
     *
     * @var String
     */
    public $search = '';

    /**
     * variable used to store attributes for new/existing user
     *
     * @var array
     */
    public $new = [
            'id'       => null,
            'name'     => '',
            'email'    => '',
            'password' => '',
        ];

    /**
     * Keep query string in sync
     *
     * @var array
     */
    protected $updatesQueryString = ['search'];

    /**
     * Mount the component
     *
     * @param string $initial
     */
    public function mount($initial = '') {
        $this->search = request('search' ,$initial);
    }

    /**
     * When fields get updated
     *
     * @param String $field
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated(String $field) {
        $this->validateOnly(
            $field,
            $this->rules(),
            [],
            $this->properties()
        );
    }

    /**
     * Reset search field
     */
    public function resetSearch () {
        $this->reset('search', 'page');
    }

    /**
     * Fills the new variable to edit a user
     *
     * @param int $id
     */
    public function edit(int $id) {
        $user = User::where('id', $id)->first();

        $this->new['id'] = $user->id;
        $this->new['name'] = $user->name;
        $this->new['email'] = $user->email;
    }

    /**
     * Persist the user
     */
    public function persist() {
        $this->validate(
            $this->rules(),
            [],
            $this->properties()
        );

        if ($this->new['id'] == null) {
            $new = new User();
        } else {
            $new = User::where('id', $this->new['id'])->first();
        }

        $new->name = $this->new['name'];
        $new->email = $this->new['email'];

        if ( $this->new['password'] !== '' ) {
            $new->password = Hash::make($this->new['password']);
        }

        $new->save();
        $this->reset('new');
    }

    /**
     * Reset the form fields
     */
    public function resetForm () {
        $this->reset('new');
    }

    /**
     * Delete a user
     *
     * @param int $id
     */
    public function delete(int $id) {
        if(Auth::user()->id == $id) {
            return;
        }

        User::where('id', $id)->first()->delete();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.users', [
            'users' => User::search($this->search)->paginate(25)
        ]);
    }

    /**
     * Create the rules dynamically for the validation of the user
     *
     * @return array
     */
    protected function rules(): array {
        if ( $this->new['id'] == null ) {
            return [
                'new.name' => 'required|min:5|max:255',
                'new.email' => 'required|email|unique:users,email',
                'new.password' => 'required|min:7'
            ];
        }

        return [
            'new.name' => 'required|min:5|max:255',
            'new.email' => 'required|email|unique:users,email' . ( $this->new['id'] ? ','.$this->new['id'] : '' ),
            'new.password' => 'nullable|min:7'
        ];
    }

    /**
     * setup properties for the validation
     *
     * @return array
     */
    protected function properties(): array {
        return [
            'new.name' => 'Name',
            'new.email' => 'E-mail',
            'new.password' => 'Password'
        ];
    }
}
