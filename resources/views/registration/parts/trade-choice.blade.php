			<div class="card">
				<div class="card-header">Course Information</div>
	
	            <div class="card-body">
		            @if(isset($errors) && $errors->count() > 0)
		            	<p class="text-danger"><strong>Please re-select your course details</strong></p>
		            @endif
		            @if ($errors->has('cost'))
		                <p><span class="help-block">
		                    <strong>{{ $errors->first('cost') }}</strong>
		                </span></p>
		            @endif
		            <div class="row form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
			            <div class="col-sm">
				            <div class="form-group">
					            <label for="course-trade">Select Trade:</label>
					            {!! Form::select('course-trade',['0'=>'Choose...']+$classes,null,['class'=>'form-control course-trade','onchange'=>"getCourseLocations()", 'required']) !!}
				            </div>
				            <div class="agreements"></div>
			            </div>
			            <div class="col-sm">
				            <div class="course-location-container" style="display:none;">
					            <label for="course-location">Select Location:</label>
					            {!! Form::select('course-location',[],null,['class'=>'form-control course-location','onchange'=>'getCourseIDs()', 'required']) !!}
				            </div>
			            </div>
			            <div class="col-sm">
				            <div class="course-id-container" style="display:none;">
					            <label for="course-id">Select Course:</label>
					            {!! Form::select('course-id',[],null,['class'=>'form-control course-id','onchange'=>'getCourseCost(); getCourseDescription();', 'required']) !!}
				            </div>
			            </div>
		            </div>
		            <div class="row">
			            <div class="col text-center">
							<div class="course-description-container" style="display:none;" class="text-center">
								<h4>Course Description:</h4>
								<div class="course-description"></div>
							</div>
				            <div class="course-cost-container" style="display:none;">
					            {!! Form::hidden('cost',null,['id'=>'cost']) !!}
					            <p>Course Cost:<br><strong><span class="course-cost"></span></strong></p>
				            </div>
			            </div>
		            </div>
	            </div>
			</div>
