			<div class="card">
				<div class="card-header">Online Course Information</div>
	
	            <div class="card-body">
		            @if(isset($errors) && $errors->count() > 0)
		            	<p class="text-danger"><strong>Please re-select your course</strong></p>
		            @endif
					{{--
		            @if ($errors->has('course-id'))
		                <p><span class="help-block">
		                    <strong>{{ $errors->first('course-id') }}</strong>
		                </span></p>
		            @endif
					--}}
		            <div class="row form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
			            <div class="col-sm">
				            <div class="course-id-container">
					            <label for="course-id">Select Course:</label>
					            {!! Form::select('course-id',['0'=>'Choose...']+$classes,null,['class'=>'form-control course-id','onchange'=>"getCourseCost('".$path."')", 'required']) !!}
				            </div>
			            </div>
		            </div>
		            <div class="row">
			            <div class="col text-center">
				            <div class="course-cost-container" style="display:none;">
					            {!! Form::hidden('cost',null,['id'=>'cost']) !!}
					            <p>Cost:<br><strong><span class="course-cost"></span></strong></p>
				            </div>
			            </div>
		            </div>
	            </div>
			</div>
