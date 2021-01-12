<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('jwt-check',['except' => ['index', 'show']]);
    }
   
    public function index()
    {
        return Expense::select('id','name', 'amount','category', 'date')
            ->paginate(100);
        
    }

    
    public function store(Request $request)
    {
        $expense = new Expense;
        $expense->name = $request->input('name');
        $expense->user_id = auth('api')->user()->id;
        $expense->category = $request->input('category');
        $expense->amount = $request->input('amount');
        $expense->date = $request->input('date');
        $expense->save();

        return response()->json(array(
            'message' => 'Expenses added!',
            'expense' => $expense
        ),201);
    }

  
    public function show($id)
    {
        $expense = Expense::find($id);
        if($expense == NULL){
            return response()->json(array(
                'message' => 'Expense not found'
            ), 404);
        }
        return response()->json($expense);
    }

    
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);
        if($expense == NULL){
            return response()->json(array(
                'message' => 'Expense not found'
            ), 404);
        }
        if($request->has('name'))
            $expense->name=$request->input('name');
        if($request->has('category'))
            $expense->category_id = $request->input('category');
        if($request->has('amount'))
            $expense->amount = $request->input('amount');
        if($request->has('date'))
            $expense->date = $request->input('date');

        $expense->save();

        return response()->json(array('message' => 'Expense Updated'));
        
    }

    
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if($expense == NULL){
            return response()->json(array(
                'message' => 'Recipe not found'
            ), 404);
        }
        $expense->delete();

        return response()->json(array(
            'message' => 'Recipe is deleted!'
        ));
    }
}
