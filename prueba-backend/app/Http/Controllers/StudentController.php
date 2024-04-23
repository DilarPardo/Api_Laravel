<?php
 
namespace App\Http\Controllers;
 
use App\Models\Student;
use Illuminate\Http\Request;

/**
* @OA\Info(
*             title="API Studentse", 
*             version="1.0",
*             description="Studentse List Api"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::paginate(5);

        return view('student.index', compact('students'))
            ->with('i', (request()->input('page', 1) - 1) * $students->perPage());
    }

    public function IndexApi()
    {
        $students = Student::all();
        return response()->json(['success' => true,'message' => 'Student list successfully','data' => $students], 200);
    }

    //IndexApi Swagger

    /**
     * Show student list
     * @OA\Get (
     *     path="/api/students",
     *     tags={"student"},
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
     *                         example="Dilar Pardo"
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
        return view('student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
 
        Student::create($request->all());
 
        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function StoreAPi(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        $student = Student::create($request->all());
        return response()->json(['success' => true,'message' => 'Student created successfully.','data' => $student], 201);
    }

    //StoreApi Swagger

    /**
     * Register student information
     * @OA\Post (
     *     path="/api/students",
     *     tags={"student"},
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
     *                     "name":"Aderson Felix"
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

    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }

    public function ShowApi(Student $student)
    {
        return response()->json(['success' => true,'message' => 'Student successfully','data' => $student], 200);
    }

    //ShowApi Swagger

    /**
     * Show student information
     * @OA\Get (
     *     path="/api/students/{id}",
     *     tags={"student"},
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
     *              @OA\Property(property="name", type="string", example="Dilar Burgos"),
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

    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
 
        $student->update($request->all());
 
        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully');
    }

    public function UpdateApi(Request $request, Student $student)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        $student->update($request->all());
        return response()->json(['success' => true,'message' => 'Student updated successfully','data' => $student], 200);
    }

    //UpdateApi Swagger

    /**
     * Update student information
     * @OA\Put (
     *     path="/api/students/{id}",
     *     tags={"student"},
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
     *                     "name": "Aderson Felix Editado"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Aderson Felix Editado"),
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

    
    public function DestroyApi(Student $student)
    {
        $student->delete();
        return response()->json(['success' => true,'message' => 'Student deleted successfully'], 200);
    }

    // DestroyApi Swagger

    /**
     * Delete student information
     * @OA\Delete (
     *     path="/api/students/{id}",
     *     tags={"student"},
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

    public function destroy(Student $student)
    {
        $student->delete();
 
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully');
    }

    

}
