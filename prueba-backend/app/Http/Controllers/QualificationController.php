<?php
 
namespace App\Http\Controllers;
 
use App\Models\Qualification;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Http\Request;
 
class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = Qualification::paginate(5);

        return view('qualification.index', compact('qualifications'))
            ->with('i', (request()->input('page', 1) - 1) * $qualifications->perPage());
    }

    public function IndexApi()
    {
        $qualifications = Qualification::all();
        return response()->json(['success' => true,'message' => 'Student list successfully','data' => $qualifications], 200);
    }

    //IndexApi Swagger

    /**
     * Show qualification list
     * @OA\Get (
     *     path="/api/qualifications",
     *     tags={"qualification"},
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
     *                         property="student_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="course_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="grade",
     *                         type="double",
     *                         example="10"
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
        $students = Student::all();
        $curses = Course::all();

        return view('qualification.create', compact('students','curses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|numeric',
        ]);

        Qualification::create($request->all());
 
        return redirect()->route('qualifications.index')
            ->with('success', 'Qualification created successfully.');
    }

    public function StoreAPi(Request $request)
    {
        $request->validate(['student_id' => 'required|exists:students,id', 'course_id' => 'required|exists:courses,id', 'grade' => 'required|numeric',]);
        $qualification = Qualification::create($request->all());
        return response()->json(['success' => true,'message' => 'qualification created successfully.','data' => $qualification], 201);
    }

    //StoreApi Swagger

    /**
     * Register qualification information
     * @OA\Post (
     *     path="/api/qualifications",
     *     tags={"qualification"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="student_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="course_id ",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="grade ",
     *                          type="double"
     *                      ),
     *                 ),
     *                 example={
     *                     "student_id":"1",
     *                     "course_id":"2",
     *                     "grade":"20"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="student_id", type="number", example="1"),
     *              @OA\Property(property="course_id", type="number", example="2"),
     *              @OA\Property(property="grade", type="double", example="20"),
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
 
    public function show(Qualification $qualification)
    {
        return view('qualification.show', compact('qualification'));
    }

    public function ShowApi(Qualification $qualification)
    {
        return response()->json(['success' => true,'message' => 'qualification successfully','data' => $qualification], 200);
    }

    //ShowApi Swagger

    /**
     * Show qualification information
     * @OA\Get (
     *     path="/api/qualifications/{id}",
     *     tags={"qualification"},
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
     *              @OA\Property(property="student_id", type="number", example="2"),
     *              @OA\Property(property="course_id", type="number", example="3"),
     *              @OA\Property(property="grade", type="double", example="50"),
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
 
    public function edit(Qualification $qualification)
    {
        $students = Student::all();
        $teachers = Teacher::all();

        return view('qualification.edit', compact('qualification','students','teachers'));
    }
 
    public function update(Request $request, Qualification $qualification)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|numeric',
        ]);
 
        $qualification->update($request->all());
 
        return redirect()->route('qualifications.index')
            ->with('success', 'Qualification updated successfully');
    }

    public function UpdateApi(Request $request, Qualification $qualification)
    {
        $request->validate(['student_id' => 'required|exists:students,id', 'course_id' => 'required|exists:courses,id', 'grade' => 'required|numeric',]);
        $qualification->update($request->all());
        return response()->json(['success' => true,'message' => 'qualification updated successfully','data' => $qualification], 200);
    }

    //UpdateApi Swagger

    /**
     * Update qualification information
     * @OA\Put (
     *     path="/api/qualifications/{id}",
     *     tags={"qualification"},
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
     *                          property="student_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="course_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="grade",
     *                          type="double"
     *                      )
     *                 ),
     *                 example={
     *                     "student_id": "2",
     *                     "course_id": "3",
     *                     "grade": "50"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="student_id", type="number", example="2"),
     *              @OA\Property(property="course_id", type="number", example="3"),
     *              @OA\Property(property="grade", type="double", example="50"),
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

    public function DestroyApi(Qualification $qualification)
    {
        $qualification->delete();
        return response()->json(['success' => true,'message' => 'qualification deleted successfully'], 200);
    }

    // DestroyApi Swagger

    /**
     * Delete qualification information
     * @OA\Delete (
     *     path="/api/qualifications/{id}",
     *     tags={"qualification"},
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
    
    public function destroy(Qualification $qualification)
    {
        $qualification->delete();
 
        return redirect()->route('qualifications.index')
            ->with('success', 'Qualification deleted successfully');
    }
}
