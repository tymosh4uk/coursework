<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Kitchen;
use App\Models\Category;
use App\Models\Ingradient;
use App\Models\Step;
use Validator;
use Storage;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;



class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $receipts = DB::table('receipts')
            ->join('categories', 'receipts.id_category', '=','categories.id')
            ->join('kitchens', 'receipts.id_kitchen', '=','kitchens.id')
            ->join('users', 'receipts.id_user', '=','users.id')
            ->select('receipts.id', 'receipts.name', 'receipts.cooking_hours', 'receipts.cooking_minutes', 'receipts.main_img as image', 'categories.category', 'kitchens.kitchen', 'users.name as username', 'users.surname')
            ->get();

        $ingradients = [];
        $ingradientsOnDB = DB::table('receipts')
            ->join('categories', 'receipts.id_category', '=','categories.id')
            ->join('kitchens', 'receipts.id_kitchen', '=','kitchens.id')
            ->join('ingradients', 'receipts.id','=','ingradients.id_receipt')
            ->select('receipts.id as id_receipt','receipts.name as name',  'ingradients.ingradient as ingradient', 'ingradients.count_ingradient', 'ingradients.type_measuring')
            ->get();
        foreach ($ingradientsOnDB as $key => $item)
            $ingradients[$item->id_receipt][] = $item;


        //dd($receipts, $ingradients);
        return [
            "receipts" => $receipts,
            "ingradients" => $ingradients
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $receipts = DB::table('users')
            ->select('users.id', DB::raw('count(receipts.id_user) as total'), 'users.surname', 'users.name', 'users.email', DB::raw("DATE_FORMAT(users.created_at, '%d-%b-%Y') as created_at"))
            ->leftJoin('receipts', 'receipts.id_user', '=', 'users.id')
            ->groupBy('users.id')
            ->orderBy('users.id')
            ->get();

        $id_receipts = array();
        foreach($receipts as $arr){
            $id_receipts[] = $arr->id;
        }
        $id_receipts_ordered = implode(',', $id_receipts);

        $users = DB::table("users")
            ->select('users.id', 'users.surname', 'users.name', 'users.email',
                DB::raw("DATE_FORMAT(users.created_at, '%d-%b-%Y') as created_at"))
            ->whereIn('users.id', $id_receipts)
            ->orderByRaw("FIELD(users.id, $id_receipts_ordered)")
            ->get();

//        $users->created_at->format('d-m-Y');

        $category = DB::table("categories")->select('category')->distinct('category')->get();
        $kitchen = DB::table("kitchens")->select('kitchen')->distinct('kitchen')->get();
        return [
            "categories" => $category,
            "kitchens" => $kitchen,
            "users" => $users,
            "receipts_count" => $receipts
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //console.log($request['step_images']);
        $request['ingradients'] = json_decode($request['ingradients']);
        $request['count_ingradients'] = json_decode($request['count_ingradients']);
        $request['type_measurings'] = json_decode($request['type_measurings']);
//        $request['step_images'] = json_decode($request['step_images']);
        $request['step_descriptions'] = json_decode($request['step_descriptions']);


//        return $request;

        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required"],
                "cooking_hours" => ["required"],
                "cooking_minutes" => ["required"],
                "category" => ["required"],
                "kitchen" => ["required"],
                "user_id" => ["required"],
                "advice" => ["nullable"]
//                "ingradients" => ["required"],
//                "ingradients.*.ingradient" => ["required"]
            ]
        );

        if($validator->fails()) {
            return [
                "status" => false,
                "errors" => $validator->messages()
            ];
        }


        $ingradients=[];

        $category = Category::create([
            "category" => $request['category']
        ]);

        $kitchen = Kitchen::create([
            "kitchen" => $request['kitchen']
        ]);



        if($request['photo']) {
            $image = $request['photo'];
            $name = time() .'_'. $image->getClientOriginalName();
            $request['photo']->storeAs('images', $name, 'public');
        }


        $receipt = Receipt::create([
            "name" => $request['name'],
            "cooking_hours" => $request['cooking_hours'],
            "cooking_minutes" => $request['cooking_minutes'],
            "main_img" => $name,
            "id_category" => $category->id,
            "id_kitchen" => $kitchen->id,
            "id_user" => $request['user_id'],
            "advice" => $request['advice'],
            "id_step" => 1
        ]);
       //return $request['count_ingradients'];

        for($i = 0; $i < count($request['ingradients']); $i++) {
            $ingradient = Ingradient::create([
                "id_receipt" => (int)$receipt['id'],
                "ingradient" => (string)$request['ingradients'][$i]->ingradient,
                "count_ingradient" => (int)$request['count_ingradients'][$i]->count_ingradient,
                "type_measuring" => (string)$request['type_measurings'][$i]->type_measuring
            ]);
            array_push($ingradients, $ingradient);


        }

        $temp = 0;

        for($i = 0; $i < $request['step_count']; $i++) {
            $step_image =  $request["step_images_".$i];
            $step_name = time() .'_'. $step_image->getClientOriginalName();
            $step_image->storeAs('step_images', $step_name, 'public');
            $temp = $i+1;
            Step::create([
                "id_receipt" => $receipt['id'],
                "step" => $temp,
                "step_image" => $step_name,
                "step_description" => $request["step_descriptions"][$i]->step_description
            ]);

        }


        return [
            "status" => true,
            "receipt" => $receipt,
            "ingradients" => $ingradients,
            "categories" => $category,
            "kitchens" => $kitchen
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = DB::table('receipts')
            ->join('categories', 'categories.id', '=', 'receipts.id_category')
            ->join('kitchens', 'kitchens.id', '=', 'receipts.id_kitchen')
            ->join('users', 'receipts.id_user', '=','users.id')
            ->select('receipts.id', 'receipts.name','receipts.cooking_hours', 'cooking_minutes', 'receipts.main_img',
            'receipts.advice', 'categories.category as category', 'kitchens.kitchen as kitchen', 'users.name as username', 'users.surname')
            ->where('receipts.id', '=', $id)
            ->get();


        $ingradients = DB::table('ingradients')
            ->select('*')
            ->where('id_receipt', '=', $id)
            ->orderBy('id')
            ->get();

        $steps = DB::table('steps')
            ->select('*')
            ->where('id_receipt', '=', $id)
            ->orderBy('id')
            ->get();

        if(!$receipt) {
            return response()->json([
                "status" => false,
                "message" => "Receipt not found"
            ])->setStatusCode(404);
        }
        if(!$ingradients) {
            return response()->json([
                "status" => false,
                "message" => "Ingradients not found"
            ])->setStatusCode(404);
        }

        return [
            "status" => true,
            "receipt" => $receipt,
            "ingradients" => $ingradients,
            "steps" => $steps
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receipt = Receipt::find($id);
//        return $receipt;
        try
        {
            Category::destroy($receipt->id_category);
            Kitchen::destroy($receipt->id_kitchen);
            Receipt::destroy($id);
            return response()->json('receipt deleted');
        }

        catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    private function saveImageToFolder(Request $request) {

        $imageU = $request->file('main_img_file');
        $name = "fgdh";
        $imageU->move(public_path('/MainImage'), $name);
    }
}
