<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GroceryListCreateRequest;
use App\Http\Requests\GroceryListUpdateRequest;
use App\Repositories\GroceryListRepository;
use App\Validators\GroceryListValidator;


class GroceryListsController extends Controller
{

    /**
     * @var GroceryListRepository
     */
    protected $repository;

    /**
     * @var GroceryListValidator
     */
    protected $validator;

    public function __construct(GroceryListRepository $repository, GroceryListValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $groceryLists = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $groceryLists,
            ]);
        }

        return view('groceryLists.index', compact('groceryLists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroceryListCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GroceryListCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $groceryList = $this->repository->create($request->all());

            $response = [
                'message' => 'GroceryList created.',
                'data'    => $groceryList->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groceryList = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $groceryList,
            ]);
        }

        return view('groceryLists.show', compact('groceryList'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $groceryList = $this->repository->find($id);

        return view('groceryLists.edit', compact('groceryList'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  GroceryListUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(GroceryListUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $groceryList = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'GroceryList updated.',
                'data'    => $groceryList->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'GroceryList deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'GroceryList deleted.');
    }
}
