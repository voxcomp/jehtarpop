			<div class="card">
				<div class="card-header">Personal Information</div>
	
	            <div class="card-body">
			        <div class="row">
						<div class="col-sm form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
				            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname',(isset($registrant['firstname']))?$registrant['firstname']:'') }}" required placeholder="First Name">
				            @if ($errors->has('firstname'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('firstname') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
				            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname',(isset($registrant['firstname']))?$registrant['lastname']:'') }}" {{(isset($showfinder) && $showfinder)?"onkeyup=getStudentList(this.value)":''}} required placeholder="Last Name">
				            @if ($errors->has('lastname'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('lastname') }}</strong>
				                </span>
				            @endif
						</div>
			        </div>
			        <div class="row">
				        <div class="col-sm">
				            <div class="students-found">
					            <p><strong>We have found the following students. Please click on any that match your information.</strong></p>
					            <div class="row no-gutters mb-2" style="border-bottom:1px solid #7c1f23"><div class="col"><strong>NAME</strong></div><div class="col"><strong>PHONE</strong></div></div>
					            <div class="list">
					            </div>
				            </div>
				            <div class="student-error"></div>
				        </div>
			        </div>
			        <div class="row">
				        <div class="col-sm">
					        <div class="row">
								<div class="col-sm form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
						            <input id="mobile" type="text" class="form-control phone" name="mobile" value="{{ old('mobile',(isset($registrant['mobile']))?$registrant['mobile']:'') }}" required placeholder="Mobile">
						            @if ($errors->has('mobile'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('mobile') }}</strong>
						                </span>
						            @endif
								</div>
								<div class="col-sm form-group{{ $errors->has('mobilecarrier') ? ' has-error' : '' }}">
									<select name="mobilecarrier" class="form-control" required>
										<option value="" disabled {{ old('mobilecarrier', isset($registrant['mobilecarrier']) ? $registrant['mobilecarrier'] : '') == '' ? 'selected' : '' }}>
											Mobile Carrier
										</option>
										@foreach ([
											"Alltel"=>"Alltel",
											"AT&T"=>"AT&T",
											"Boost Mobile"=>"Boost Mobile",
											"Cricket Wireless"=>"Cricket Wireless",
											"Project Fi"=>"Project Fi",
											"Sprint"=>"Sprint",
											"T-Mobile"=>"T-Mobile",
											"U.S. Cellular"=>"U.S. Cellular",
											"Verizon"=>"Verizon",
											"Virgin Mobile"=>"Virgin Mobile",
											"Republic Wireless"=>"Republic Wireless",
											"MetroPCS"=>"MetroPCS",
											"Straight Talk"=>"Straight Talk",
											"Simple Mobile"=>"Simple Mobile",
											"Xfinity Mobile"=>"Xfinity Mobile"
										] as $key => $label)
											<option value="{{ $key }}" {{ old('mobilecarrier', $registrant['mobilecarrier'] ?? '') == $key ? 'selected' : '' }}>
												{{ $label }}
											</option>
										@endforeach
									</select>
									
						            @if ($errors->has('mobilecarrier'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('mobilecarrier') }}</strong>
						                </span>
						            @endif
								</div>
					        </div>
					        <p><small>Entering your mobile phone carrier on this form gives Gould permission to text you regarding matters with the education program.</small></p>
				        </div>
						<div class="col-sm">
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					            <input id="email" type="email" class="form-control" name="email" value="{{ old('email',(isset($registrant['email']))?$registrant['email']:'') }}" required placeholder="E-mail">
					            @if ($errors->has('email'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('email') }}</strong>
					                </span>
					            @endif
						        <p style="margin-top:15px;"><small>Entering your email address on this form gives Gould permission to email you regarding matters with the education program.</small></p>
							</div>
						</div>
					</div>
					@if($path=="trade")
						<div class="row">
							<div class="col-sm-6 form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
					            <input id="dob" type="text" class="datepicker form-control" name="dob" value="{{ old('dob',(isset($register['dob']))?$register['dob']:'') }}" required autocomplete="off" placeholder="Birthdate">
					            @if ($errors->has('dob'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('dob') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
					@endif
					@if(isset($showradiobuttons) && $showradiobuttons)
						<hr>
				        <div class="row">
					        <div class="col-sm">
									<p><strong>Division of Apprentice Standards (DAS) Registered apprentice (<a href="https://www.mass.gov/info-details/explore-apprenticeships-in-massachusetts#become-an-apprentice-in-the-building-trades-" target="_blank">more info</a>):</strong><br>{{ html()->radio('das', old('das', 0) == 1 ? true : false, 1) }} Yes &nbsp; {{ html()->radio('das', old('das', 0) == 0 ? true : false, 0) }} No</p>
					        </div>
							<div class="col-sm">
									<p><strong>Building Mass Careers Apprentice Program (BMC-AP):</strong><br>{{ html()->radio('map', old('map', 0) == 1 ? true : false, 1) }} Yes &nbsp; {{ html()->radio('map', old('map', 0) == 0 ? true : false, 0) }} No</p>
							</div>
						</div>
					@endif
					<hr>
					<h3>Registrant Address</h3>
					<div class="row form-group{{ $errors->has('address') ? ' has-error' : '' }}">
				        <div class="col-sm">
				            <input id="address" type="text" class="form-control" name="address" value="{{ old('address',(isset($registrant['address']))?$registrant['address']:'') }}" placeholder="Address">
				            @if ($errors->has('address'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('address') }}</strong>
				                </span>
				            @endif
				        </div>
					</div>
					<div class="row form-group">
						<div class="col-sm-6 col-xs-12 col-spacing{{ $errors->has('city') ? ' has-error' : '' }}">
				            <input id="city" type="text" class="form-control" name="city" value="{{ old('city',(isset($registrant['city']))?$registrant['city']:'') }}" placeholder="City">
				            @if ($errors->has('city'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('city') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-2 col-xs-4 col-spacing{{ $errors->has('state') ? ' has-error' : '' }}">
				            <input id="state" type="text" class="form-control" name="state" value="{{ old('state',(isset($registrant['state']))?$registrant['state']:'') }}" placeholder="State">
				            @if ($errors->has('state'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('state') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-4 col-xs-8{{ $errors->has('zip') ? ' has-error' : '' }}">
				            <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip',(isset($registrant['zip']))?$registrant['zip']:'') }}" placeholder="Zip Code">
				            @if ($errors->has('zip'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('zip') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
	            </div>
			</div>
