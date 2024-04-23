<?php
 
namespace App\Http\Controllers;
 
use App\Models\Course;
use Illuminate\Http\Request;
 
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::paginate(5);

        return view('course.index', compact('courses'))
            ->with('i', (request()->input('page', 1) - 1) * $courses->perPage());
    }

    public function IndexApi()
    {
        $courses = Course::all();
        return response()->json(['success' => true,'message' => 'teacher updated successfully','data' => $courses], 200);
    }

    //IndexApi Swagger

    /**
     * Show course list
     * @OA\Get (
     *     path="/api/courses",
     *     tags={"course"},
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
     *                         property="title",
     *                         type="string",
     *                         example="Primero 1"
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
        return view('course.create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
 
        $course = Course::create($request->all());
 
        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function StoreAPi(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255',]);
        $course = Course::create($request->all());
        return response()->json(['success' => true,'message' => 'course created successfully.','data' => $course], 201);
    }

    //StoreApi Swagger

    /**
     * Register course information
     * @OA\Post (
     *     path="/api/courses",
     *     tags={"course"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "title":"segundo"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="segundo"),
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
 
    public function show(Course $course)
    {
        $teachers = $course->teachers;
        $qualifications = $course->qualifications;
        return view('course.show', compact('course', 'teachers', 'qualifications'));
    }

    public function ShowApi(Course $course)
    {
        return response()->json(['success' => true,'message' => 'course successfully','data' => $course], 200);
    }

    //ShowApi Swagger

    /**
     * Show course information
     * @OA\Get (
     *     path="/api/courses/{id}",
     *     tags={"course"},
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
     *              @OA\Property(property="title", type="string", example="quinto"),
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
 
    public function edit(Course $course)
    {
        return view('course.edit', compact('course'));
    }
 
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
 
        $course->update($request->all());
 
        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    public function UpdateApi(Request $request, Course $course)
    {
        $request->validate(['title' => 'required|string|max:255',]);
        $course->update($request->all());
        return response()->json(['success' => true,'message' => 'course updated successfully','data' => $course], 200);
    }

    //UpdateApi Swagger

    /**
     * Update course information
     * @OA\Put (
     *     path="/api/courses/{id}",
     *     tags={"course"},
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
     *                          property="title",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title": "tercero"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="Tercero"),
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
    public function DestroyApi(Course $course)
    {
        $course->delete();
        return response()->json(['success' => true,'message' => 'course deleted successfully'], 200);
    }

    // DestroyApi Swagger

    /**
     * Delete course information
     * @OA\Delete (
     *     path="/api/courses/{id}",
     *     tags={"course"},
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
    
    public function destroy(Course $course)
    {
        $course->delete();
 
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
