<?php

// namespace Modules\User\Http\Controllers;

// use App\Models\User;
// use Illuminate\Contracts\Support\Renderable;
// use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
// use Illuminate\Support\Facades\Auth;
// use Modules\User\Entities\Group;
// use Modules\User\Services\UserGroupService;
// use Modules\User\Repositories\UserGroupRepository;
// use Modules\User\http\Requests\UserGroupRequest;
// use Modules\User\Services\GroupMembersService;

// class UserGroupController extends Controller
// {
//     private $userGroupService;
//     private $userGroupRepository;

//     public function __construct(UserGroupService $userGroupService , UserGroupRepository $userGroupRepository)
//     {
//         $this->userGroupService     = $userGroupService;
//         $this->userGroupRepository  = $userGroupRepository;
//     }
//     /**
//      * Display a listing of the resource.
//      * @return Renderable
//      */
//     public function index()
//     {
//         $user       = Auth::user();
//         $userGroups = $this->userGroupRepository->getAllUserGroup($user->id);
//         return view('user::index' , compact('userGroups'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      * @return Renderable
//      */
//     public function create()
//     {
//         return view('user::create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      * @param Request $request
//      * @return Renderable
//      */
//     public function store(UserGroupRequest $request)
//     {
//         $user = Auth::user();
//         $userGroup = $this->userGroupService
//         ->setUser($user)
//         ->setName($request->group_name)
//         ->setDescription($request->group_description)
//         ->setImage($request->group_image)
//         ->setIsPublic($request->is_public)
//         ->createUserGroup()
//         ->getData();

//         return redirect()->back()->with($userGroup->success,$userGroup->message);
//     }

//     /**
//      * Show the specified resource.
//      * @param int $id
//      * @return Renderable
//      */
//     public function show($id)
//     {
//         return view('user::show');
//     }

//     /**
//      * Show the form for editing the specified resource.
//      * @param int $id
//      * @return Renderable
//      */
//     public function edit($id)
//     {
//         return view('user::edit');
//     }

//     /**
//      * Update the specified resource in storage.
//      * @param Request $request
//      * @param int $id
//      * @return Renderable
//      */
//     public function update(UserGroupRequest $request, $id)
//     {
//         $group_user = User::where('id' , Auth::id())->whereHas('ownerGroups' , function($group) use($id){
//             $group->where('groups.id' , $id);
//         })->get();

//         if($group_user->isEmpty()) {
//             return redirect()->route('')->with('failed',"This group is Not Found");
//         }
//         $group = Group::find($id);
//         $userGroup = $this->userGroupService
//         ->setName($request->group_name)
//         ->setDescription($request->group_description)
//         ->updateImage($request->group_image , $group->group_image)
//         ->setIsPublic($request->is_public)
//         ->updateGroup($group)
//         ->getData();

//         return redirect()->back()->with($userGroup->success,$userGroup->message);
//     }

//     /**
//      * Remove the specified resource from storage.
//      * @param int $id
//      * @return Renderable
//      */
//     public function destroy($id)
//     {
//         //
//     }

//     /**
//      * Invite User to group
//      */

//      public function invite(Request $request , $id)
//      {
//         $group_user = User::where('id' , Auth::id())->whereHas('supervisorGroups' , function($group) use($id){
//             $group->where('groups.id' , $id);
//         })->get();

//         if($group_user->isEmpty()) {
//             return redirect()->route('')->with('failed',"This group is Not Found");
//         }
//         $groupMemberService = new GroupMembersService();
//         $invite = $groupMemberService
//         ->setUserId($request->user_id)
//         ->setGroupId($request->group_id)
//         ->inviteUser()
//         ->getData();

//         return redirect()->back()->with($invite->success,$invite->message);
//      }

//      /**
//      * Add User to group
//      */

//     public function add(Request $request , $id)
//     {
//        $group_user = User::where('id' , Auth::id())->whereHas('ownerGroups' , function($group) use($id){
//            $group->where('groups.id' , $id);
//        })->get();

//        if($group_user->isEmpty()) {
//            return redirect()->route('')->with('failed',"This group is Not Found");
//        }
//        $groupMemberService = new GroupMembersService();
//        $add = $groupMemberService
//        ->setUserId($request->user_id)
//        ->setGroupId($request->group_id)
//        ->addUser()
//        ->getData();

//        return redirect()->back()->with($add->success,$add->message);
//     }
//}
