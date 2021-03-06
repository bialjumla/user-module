<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\Company;
use Modules\User\Entities\Customer;
use Modules\User\Entities\Indevidual;
use Modules\User\Enum\UserEnum;
use Spatie\Permission\Models\Role;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Services\UserService;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Advertisement\Enum\AdvertisementPositionEnum;
use Modules\Advertisement\Repositories\AdvertisementRepository;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\ProductStatus;
use Modules\Product\Repositories\ProductRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Wallet\Entities\Wallet;

class UserController extends Controller
{
    private $userRepository;
    private $productRepository;


    public function __construct()
    {
         $this->userRepository              = new UserRepository();
         $this->productRepository           = new ProductRepository();
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users      = User::select()->orderBy('id', UserEnum::DESPLAY_ORDER)->with(['roles'])->get();
        $table      = 'users';
        $columns    = ['name', 'email', 'phone'];
        $actions    = ['create','edit','activate','delete' ];

        return view('user::dashboard.index',[
            'data'          => $users,
            'table'         => $table,
            'columns'       => $columns,
            'actions'       => $actions,
        ]);
    }

    public function getUsersByRole($role)
    {
        $users=User::role($role)->orderBy('id','DESC')->with(['roles'])->get();

        return view('user::dashboard.index',['users'=>$users,'role'=>$role]);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::all();

        return view('user::dashboard.create',['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(UserRequest $request)
    {
        $newUser =new UserService();
        $newUser ->setName($request->name)
                 ->setEmail($request->email)
                 ->setPhone($request->phone)
                 ->setImage($request->image)
                 ->setPassword($request->password);

        $user=$newUser->createUser();
        $user->assignRole($request->input('roles'));

        if($user->hasRole('company'))
            Company::create(['id'=>$user->id]);
        // if($user->hasRole('indevidual'));
        //     Indevidual::create(['id'=>$user->id]);
        if($user->hasRole('customer'))
            Customer::create(['id'=>$user->id]);

        //create wallet to the user
        $wallet = new Wallet();
        $wallet->id = $user->id;
        $wallet->save();

        return redirect()->route('users.index')->with('success','User created successfully');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);
        if(!$user){
            return redirect()->route('dashboard')->with('failed',"User Not Found");
        }

        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('user::dashboard.edit',
                    [
                    'user'      =>$user,
                    'roles'     =>$roles,
                    'userRole'  =>$userRole
                    ]
                );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'image' => 'nullable',
            'phone' => 'max:14,number|nullable',
        ]);
       $user = User::find($id);
        if(!$user){
            return redirect()->route('dashboard')->with('failed',"User Not Found");
        }

        $updateUser =new UserService();
        $updateUser  ->setName($request->name)
                     ->setEmail($request->email)
                     ->setPhone($request->phone??$user->phone);
                     if($request->has('image')){
                        $updateUser->updateImg($request->image ,$user->image);
                        }
                     if(!empty($request->password)){
                     $updateUser->setPassword($request->password);
                     }

        $updatedUser=$updateUser->updateUser($user);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user=User::find($id);
        if (!$user) {
            return redirect()->route('dashboard')->with('failed',"User Not Found");
        }
        $user->delete();
        return 'user deleted ';
    }

    public function activate($id)
    {

        $user=User::find($id);
        if (!$user) {
            return redirect()->route('dashboard')->with('failed',"User Not Found");
        }
        $user->is_active = !$user->is_active;
        $user->save();
    }

    public function getUserProfile($name)
    {
        $user           = User::where('name' , $name)->first();
        if (!$user){
            abort(404);
        }

        $currantUser    = Auth::user();
        $isCurrantUser  = $currantUser->name === $user->name;

        // $data           = $this->productRepository->getUserProducts($user);

        $categories     = Category::all();
        $statuses       = ProductStatus::all();

        return view('user::website.profile.index', compact('user','categories', 'statuses','isCurrantUser'));

    }

    public function settingPage()
    {
        return view('user::website.profile.settings');
    }
}
