<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="student" class="form-label">{{ __('Student Id') }}</label>

            <select class="form-select" aria-label="Default select example" name="student_id" id="student_id">     
                <option value="" disabled selected>select</option> 
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>     
                    @endforeach 
            </select>
            {!! $errors->first('student_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="course" class="form-label">{{ __('Course Id') }}</label>
            
            <select class="form-select" aria-label="Default select example" name="course_id" id="course_id">     
                <option value="" disabled selected>select</option> 
                    @foreach ($curses as $curse)
                        <option value="{{ $curse->id }}">{{ $curse->title }}</option>     
                    @endforeach 
            </select>
            {!! $errors->first('course_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="grade" class="form-label">{{ __('Grade') }}</label>
            <input type="text" name="grade" class="form-control @error('grade') is-invalid 
             @enderror" value="{{ old('grade', isset($qualification) ? $qualification->grade : '') }}" 
             id="grade" placeholder="grade">
            {!! $errors->first('grade', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>