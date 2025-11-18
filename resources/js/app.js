/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 import $ from 'jquery';
  window.$ = window.jQuery = $;

import 'bootstrap';
import 'jquery-ui-dist/jquery-ui.min.js';
 
 // Legacy jQuery plugins
 import './jquery.autocomplete.min.js';
 import './jquery.form.min.js';
 import './jquery.mask.min.js';
 import './progress.js';



(function($) {
	window.getCourseLocations = function() {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/course/location/'+$('.course-trade').val(),
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
	            for( let prop in data ){
					$('.agreements').html('');
		            if(prop == 'locations') {
			            $('.course-location').empty();
			            $('.course-location').append('<option value="0">Choose...</option>');
			            $('.course-id-container').fadeOut(200);
			            $('.course-id').empty();
			            $('.course-cost-container').fadeOut(200);
			            $('.course-cost').text('');
			            $('#cost').val('0');
			            for( let loc in data[prop] ){
				            $('.course-location').append('<option value="'+loc+'">'+data[prop][loc]+'</option>');
						}
						$('.course-location-container').fadeIn(200);
					}else if(prop == 'agreements') {
						$('.agreements').html('');
						var c = 0;
			            for( let agree in data[prop] ){
				            c++;
						    $('.agreements').append(
						        $(document.createElement('input')).prop({
						            id: 'a_'+$('.course-trade').val()+'_'+c,
						            name: 'a_'+$('.course-trade').val()+'_'+c,
						            value: '1',
						            type: 'checkbox',
						            class: 'inline',
						            required: true
						        })
						    ).append(
						        $(document.createElement('label')).prop({
						            for: 'a_'+$('.course-trade').val()+'_'+c,
						            class: 'inline'
						        }).html(data[prop][agree])
						    ).append(document.createElement('br'));
						}
					}
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
	window.getCourseIDsAjax = function(url) {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
	            for( let prop in data ){
		            $('.course-id').empty();
		            $('.course-id').append('<option value="0">Choose...</option>');
		            $('.course-cost-container').fadeOut(200);
		            $('.course-cost').text('');
		            $('#cost').val('0');
		            for( let loc in data[prop] ){
			            $('.course-id').append('<option value="'+loc+'">'+data[prop][loc]+'</option>');
					}
					$('.course-id-container').fadeIn(200);
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
	window.getCourseIDs = function(path = 'trade') {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		if($('.course-location').val()!='0') {
			if(path=='trade') {
				url = '/ajax/course/courses/'+path+'/'+$('.course-trade').val()+'/'+$('.course-location').val();
				if($('.course-location').val()=='Andover' || $('.course-location').val()=="Woburn") {
					$('#dialog-confirm').html("<strong>Disclaimer:</strong>  Please note that there is a possibility of your class being relocated to a new training facility in Billerica after the winter break. By registering for this class, you agree to remain enrolled for the entire school year and to relocate to the Billerica location if and when the change occurs during this school year.");
				    $("#dialog-confirm").dialog({
				        resizable: false,
				        show: {
					        effect: "fade",
					        duration: 300
				        },
				        hide: {
					        effect: "fade",
					        duration: 300
				        },
				        open: function(event,ui) {
					        $(".ui-widget-overlay").addClass('custom-overlay');
					        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
				        },
				        close: function(event,ui) {
					        $(".ui-widget-overlay").removeClass('custom-overlay');
				        },
				        modal: true,
				        title: "Location Notice",
				        height: 250,
				        width: 400,
				        buttons: {
				            "I Agree": function () {
				                $(this).dialog('close');
								getCourseIDsAjax(url);
				            },
				            "Cancel": function () {
								$('.course-location').val('0');
				            }
				        }
				    });
				} else {
					getCourseIDsAjax(url);
				}
			} else {
				url = '/ajax/course/courses/'+path+'/'+$('.course-trade').val();
				getCourseIDsAjax(url);
			}
		}
	}
	window.getCourseCost = function(path = 'trade') {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/course/cost/'+path+'/'+$('.course-id').val(),
            type: 'POST',
            dataType: 'HTML',
            success: function(data) {
	            if(data!='error') {
		            $('.course-cost').text('$'+parseInt(data).toFixed(2));
		            $('#cost').val(data);
					$('.course-cost-container').fadeIn(200);
				} else {
		            $('.course-cost').text('');
		            $('#cost').val(0);
		            $('.course-id').val("0");
					alert("There was an error retrieving the cost of the course chosen.");
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
	window.getCourseDescription = function(path = 'trade') {
		if(path=='trade') {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: '/ajax/class/description/'+$('.course-id').val(),
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					if(!data.hasOwnProperty('notfound')) {
						$('.course-description').html(data.description.replace(/(?:\r\n|\r|\n)/g, '<br>'));
						$('.course-description-container').fadeIn(200);
					} else {
						$('.course-description-container').fadeOut(200)
						$('.course-description').html('');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
				}
			});
		}
	}
	
	window.getStudentCourseCost = function() {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/course/student/cost/'+$('.course-id').val(),
            type: 'POST',
            dataType: 'HTML',
            success: function(data) {
		            $('.course-cost').text('$'+parseInt(data).toFixed(2));
		            $('#cost').val(data);
					$('.course-cost-container').fadeIn(200);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
window.getEventTickets = function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: '/ajax/event/tickets/' + $('.event-name').val(),
			type: 'POST',
			dataType: 'JSON',
			success: function(data) {
				for (let tickets in data) {
					$('.event-ticket').empty();
					$('.event-ticket').append('<option value="0">Choose...</option>');
					$('#cost').val('0');
					for (let item in data[tickets]) {
						$('.event-ticket').append('<option value="' + item + '">' + data[tickets][item] + '</option>');
					}
					if ($('.event-ticket').children('option').length > 1) {
						// Show container and make select required
						$('.event-ticket-container').fadeIn(200);
						$('.event-ticket').attr('required', 'required');
					} else {
						// Hide container and remove required
						$('.event-ticket-container').fadeOut(200);
						$('.event-ticket').removeAttr('required');
					}
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// On error, also hide and remove required
				$('.event-ticket-container').fadeOut(200);
				$('.event-ticket').removeAttr('required');
			}
		});
	}
	window.getEventCost = function(path) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/event/cost/'+$('.event-ticket').val(),
            type: 'POST',
			data: {path:path},
            dataType: 'HTML',
            success: function(data) {
		            $('.event-cost').text('$'+parseInt(data).toFixed(2));
		            $('#cost').val(data);
					$('.event-cost-container').fadeIn(200);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
	window.copyDue = function(applied) {
		$(".applied").val(applied);
	}
	window.copyPO = function(ponum) {
		$(".ponum").val(ponum);
	}
	window.copyResponsible = function(responsible) {
		$(".responsible").val(responsible);
	}
	window.getCompanyName = function(partial) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$("#company").val('0');
		if(partial.length > 4) {
	        $.ajax({
	            url: '/ajax/company/lookup/'+partial,
	            type: 'POST',
	            dataType: 'JSON',
	            success: function(data) {
		            //data = JSON.parse(data);
		            //console.log(data);
		            $(".companies").html('');
		            for(var i=0;i<data.length;i++) {
			            $(".companies").append('<div><a href="#" onclick="getCompanyInformation('+data[i].id+')">'+data[i].name+'</a>');
		            }
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    }
	}
	window.getCompanyInformation = function(company) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/company/'+company,
            type: 'POST',
            dataType: 'HTML',
            success: function(data) {
	            data = JSON.parse(data);
	            $("#company").val(data.id);
	            $(".companies").html('');
	            $("#name").val(data.name);
	            $("#address").val(data.address);
	            $("#phone").val(data.phone);
	            $("#city").val(data.city);
	            $("#state").val(data.state);
	            $("#zip").val(data.zip);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
	window.getStudentList = function(partial) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		if(partial.length > 2) {
			//console.log('/ajax/student/lookup/'+partial+(($("#firstname").val().length)?'/'+$("#firstname").val():''));
	        $.ajax({
	            url: '/ajax/student/lookup/'+partial+(($("#firstname").val().length)?'/'+$("#firstname").val():''),
	            type: 'POST',
	            dataType: 'JSON',
	            success: function(data) {
/*
		            console.log(data);
		            data = JSON.parse(data);
		            console.log(data);
*/
					$(".student-error").html('');
		            $(".students-found").hide();
		            $(".students-found .list").html('');
		            for(var i=0;i<data.length;i++) {
			            $(".students-found .list").append('<div class="row no-gutters mb-2"><div class="col"><a href="#" onclick="getStudentInformation('+data[i].id+')">'+data[i].first+' '+data[i].last+'</a></div><div class="col">###-###-'+data[i].mobile.substr(data[i].mobile.length - 4)+'</div></div>');
		            }
		            if(data.length) {
			            $(".students-found").show();
			        }
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    }
	}
	window.getStudentInformation = function(student) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/student/'+student,
            type: 'POST',
            dataType: 'HTML',
            success: function(data) {
	            data = JSON.parse(data);
	            if(data.balance<=0) {
		            $("#indid").val(data.indid);
		            $("#firstname").val(data.first);
		            $("#lastname").val(data.last);
		            $("#mobile").val(data.mobile);
		            $("#mobilecarrier").val(data.mobilecarrier);
		            $("#email").val(data.email);
		            $("#address").val(data.address);
		            $("#city").val(data.city);
		            $("#state").val(data.state);
		            $("#zip").val(data.zip);
		        } else {
			        $(".student-error").html('<strong>This person has an outstanding balance and cannot be registered until that balance is paid in full.<br><a href="/balance/'+data.id+'">The balance can be paid online here.</a></strong>').fadeIn(200);
		        }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}
	window.checkCoupon = function(coupon,el,path) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		if(coupon.length==0) {
			coupon='xxxxx';
		}
        $.ajax({
            url: "/ajax/coupon/"+coupon+"/"+path,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
// 	            console.log(data);
                if(!data.status) {
	                $("#"+el).parent().find(".alert").remove();
	                if(coupon!='xxxxx') {
		                $("#"+el).parent().addClass("has-error").append('<div class="alert-danger alert">The discount code entered is not valid.</div>');
		            }
	                $(".coupon").val('');
	                $(".discount").text('0.00');
	                $(".total").text(data.total.toFixed(2));
                } else {
	                $("#"+el).parent().removeClass("has-error").addClass("has-success").find(".alert").remove();
	                $(".coupon").val($("#"+el).val());
	                $(".discount").text(data.value.toFixed(2));
	                $(".total").text(data.total.toFixed(2));
                }
            }
        });
	}
	window.AjaxConfirmDialog = function(msg, title, url, redirect, record, reload=true, el=null, showstatus=false, statusel=null) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

	    $("#dialog-confirm").html(msg);
	
	    // Define the Dialog and its properties.
	    $("#dialog-confirm").dialog({
	        resizable: false,
	        show: {
		        effect: "fade",
		        duration: 300
	        },
	        hide: {
		        effect: "fade",
		        duration: 300
	        },
	        open: function(event,ui) {
		        $(".ui-widget-overlay").addClass('custom-overlay');
		        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
	        },
	        close: function(event,ui) {
		        $(".ui-widget-overlay").removeClass('custom-overlay');
	        },
	        modal: true,
	        title: title,
	        height: 250,
	        width: 400,
	        buttons: {
	            "Yes": function () {
	                $(this).dialog('close');
	                if(record!='') {
		                $.ajax({
			                url: url,
			                data: {record : record},
			                type: 'POST',
			                dataType: 'html',
			                success: function(data) {
				                if($redirect!='')
					                window.location = redirect;
			                }
		                });
	                } else {
		                $.ajax({
			                url: url,
			                type: 'POST',
			                dataType: 'html',
			                success: function(data) {
				                if(reload) {
					                window.location = redirect;
					            } else {
						            if(el!==null) {
							            el.fadeOut(300,function() { el.remove(); });
							        } else if(showstatus) {
								        statusel.removeClass('hide').text(data).slideDown(300,function() {
									        statusel.fadeTo(2000, 500).slideUp(500, function(){
											    statusel.slideUp(500);
											});
								        });
							        }
					            }
			                }
		                });
	                }
	            },
	            "No": function () {
	                $(this).dialog('close');
	            }
	        }
	    });
	}
	window.SubmitConfirmDialog = function(msg, title, formEl) {
	    $("#dialog-confirm").html(msg);
	
	    // Define the Dialog and its properties.
	    $("#dialog-confirm").dialog({
	        resizable: false,
	        show: {
		        effect: "fade",
		        duration: 300
	        },
	        hide: {
		        effect: "fade",
		        duration: 300
	        },
	        open: function(event,ui) {
		        $(".ui-widget-overlay").addClass('custom-overlay');
		        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
	        },
	        close: function(event,ui) {
		        $(".ui-widget-overlay").removeClass('custom-overlay');
	        },
	        modal: true,
	        title: title,
	        height: 350,
	        width: 400,
	        buttons: {
	            "I agree": function () {
	                $(this).dialog('close');
					formEl.submit();
	            },
	            "No": function () {
	                $(this).dialog('close');
	            }
	        }
	    });
	}
	$(document).ready(function() {
		$('.paymentform').on("submit",function(e) {
			e.preventDefault();
			if($('#due').length) {
				$('.applied').val($('#due').val());
			}
			this.submit();
		});
	    $( "input.datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:2030",
			altFormat:"mm-dd-YYYY"
	    });
	    if($('input.datepicker').length) {
			$("input.datepicker").mask("90/90/0000");
	    }
	    if($('input.phone').length) {
			$("input.phone").mask("000-000-0000");
	    }
	    if($('input.ccard').length) {
			$("input.ccard").mask("0000 0000 0000 0009");
	    }
		if($('input.money').length) {
			$("input.money").mask("000000.00",{reverse: true});
		}
		
	});
    if($(".alert").length) {
		$(".alert").not(".nohide").fadeTo(30000, 500).slideUp(500, function(){
		    $(".alert").slideUp(500);
		});
    }
})(window.jQuery);