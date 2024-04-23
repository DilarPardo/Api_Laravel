<?php
 
namespace App\Http\Controllers;
 
use App\Models\Teacher;
use Illuminate\Http\Request;

 
class TeacherController extends Controller
{

    public function index(Request $request)
    {
        $teachers = Teacher::paginate(5);

        return view('teacher.index', compact('teachers'))
            ->with('i', (request()->input('page', 1) - 1) * $teachers->perPage());
    }

    public function IndexApi()
    {
        $teachers = Teacher::all();
        return response()->json(['success' => true,'message' => 'teacher updated successfully','data' => $teachers], 200);
    }

    //IndexApi Swagger

     /**
     * Show teacher list
     * @OA\Get (
     *     path="/api/teachers",
     *     tags={"teacher"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Profesor Pedrosa"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="datetime",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="datetime",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function create()
    {
        return view('teacher.create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
 
        Teacher::create($request->all());
 
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function StoreAPi(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        $teachers = Teacher::create($request->all());
        return response()->json(['success' => true,'message' => 'teacher created successfully.','data' => $teachers], 201);
    }

    //StoreApi Swagger

    /**
     * Register teacher information
     * @OA\Post (
     *     path="/api/teachers",
     *     tags={"teacher"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"Profesor Aderson casanova"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Aderson Felix"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The apellidos field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */

 
    public function show(Teacher $teacher)
    {
        return view('teacher.show', compact('teacher'));
    }

    public function ShowApi(Teacher $teacher)
    {
        return response()->json(['success' => true,'message' => 'Teacher successfully','data' => $teacher], 200);
    }

    //ShowApi Swagger

    /**
     * Show teacher information
     * @OA\Get (
     *     path="/api/teachers/{id}",
     *     tags={"teacher"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Profesor Carlos Prada"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */
 
    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }
 
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
 
        $teacher->update($request->all());
 
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');
    }

    public function UpdateApi(Request $request, Teacher $teacher)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        $teacher->update($request->all());
        return response()->json(['success' => true,'message' => 'Teacher updated successfully','data' => $teacher], 200);
    }

    //UpdateApi Swagger

    /**
     * Update teacher information
     * @OA\Put (
     *     path="/api/teachers/{id}",
     *     tags={"teacher"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Profesor Felix Editado"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Profesor Felix Editado"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The apellidos field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
 
    public function DestroyApi(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(['success' => true,'message' => 'Teacher deleted successfully'], 200);
    }

    // DestroyApi Swagger

    /**
     * Delete teacher information
     * @OA\Delete (
     *     path="/api/teachers/{id}",
     *     tags={"teacher"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="NO CONTENT"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No se pudo realizar correctamente la operación"),
     *          )
     *      )
     * )
     */

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
 
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }
}
