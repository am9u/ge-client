<?php if ( ! empty($message)) { ?>
    <div class="message"><?php echo $message; ?></div>
<?php } ?>

<div class="form" id="event_form">

<?php echo Form::open() ?>
    <?php if ( ! empty($event)) { echo Form::hidden('id', $event->id); } ?>
    <?php if ( ! empty($group_id)) { echo Form::hidden('group_id', $group_id); } ?>

    <h3><a href="#">Where</a></h3>
    <div>
        <div class="form-field">
            <?php 
                /** Returns array in format that can populate select options for HTML::select() */
                function _select_element_arr($arr, $key_name, $value_name)
                {
                    $options = array(
                            '0' => ''
                        );

                    foreach($arr as $option)
                    {
                        $options[$option[$key_name]] = $option[$value_name];
                        //Arr::extract($arr, array($key_name, $value_name));
                    }

                    return $options;
                }

                $select_venues = _select_element_arr($venues, 'id', 'name');

                echo Form::label('venue_id', 'Select Venue'); 
            ?>

            <div class="input" style="width:30em">
                <?php echo Form::select('venue_id', $select_venues, (empty($event)) ? NULL : $event->venue_id, array('id' => 'venues_combobox')); ?>
            </div>
        </div>

        <div class="form-field">
            <div class="input">
                or
                <?php echo HTML::anchor(Request::instance()->uri(array('controller' => 'venue', 'action' => 'create')), 'Add New Venue', array('class' => 'button', 'style' => 'white-space:nowrap')); ?>
            </div>
        </div>

        <a href="#/1" class="button button-workflow-next">Next</a>
    </div>

    <h3><a href="#">When</a></h3>
    <div>
        <div class="form-field">
            <?php echo Form::label('date', 'Date'); ?>
            <div class="input" style="width:30em">
                <?php echo Form::input('date', (empty($event)) ? NULL : $event->date, array('id' => 'datepicker')); ?>
            </div>
        </div>

<?php
    $hours_12_step = Date::hours();

    $time_slots = array();
    foreach(Date::hours(1, TRUE) as $hours)
    {
        foreach(Date::minutes(15) as $minutes)
        {
            $time_slot = $hours.':'.$minutes;

            if ($hours > 12)
            {
                $step_12_time = $hours - 12;
            }
            elseif ($hours == 0)
            {
                $step_12_time = 12;
            }
            else
            {
                $step_12_time = $hours;
            }

            $step_12_time .= ':'.$minutes.' '.strtolower(Date::ampm($hours));

            $time_slots[$time_slot] = $step_12_time;
        }
    }
?>
        <div class="form-field">
            <?php echo Form::label('time', 'Time'); ?>
            <div class="input" style="width:30em">
                <?php echo Form::select('time', $time_slots, (empty($event)) ? '19:30' : $event->time, array('id' => 'timepicker')); ?>
            </div>
        </div>

        <div class="form-field">
            <?php 
                /*
                echo Form::label('datetime', 'DateTime'); 
                echo Form::input('datetime', (empty($event)) ? Date::formatted_time('now', 'Y-m-d').' 19:30:00'  : $event->datetime, array('class' => 'input', 'id' => 'datetime'));
                //*/
                echo Form::hidden('datetime', (empty($event)) ? Date::formatted_time('now', 'Y-m-d').' 19:30:00'  : $event->datetime, array('class' => 'input', 'id' => 'datetime'));
            ?>
        </div>

        <a href="#/2" class="button button-workflow-next">Next</a>
    </div>

    <h3><a href="#">What</a></h3>
    <div>
        <div class="form-field">
            <?php 
                echo Form::label('name', 'Name'); 
                echo Form::input('name', (empty($event)) ? '' : $event->name, array('id' => 'event_name', 'class' => 'input'));
            ?>
        </div>

        <div class="form-field form-field-textarea">
            <?php 
                echo Form::label('description', 'Description'); 
                echo Form::textarea('description', (empty($event)) ? '' : $event->description, array(
                    'width'  => '40',
                    'height' => '20',
                    'class'  => 'input' 
                )); 
            ?>
        </div>

        <div class="form-field form-field-textarea">
            <?php 
                echo Form::label('menu', 'Menu'); 
                echo Form::textarea('menu', (empty($event)) ? '' : $event->menu, array(
                    'width'  => '40',
                    'height' => '20',
                    'class'  => 'input' 
                )); 
            ?>
        </div>


        <? /** SAMPLE TAG FIELDS
        <?php 
            echo Form::hidden('tags[]', 1); 
        ?>
        <div class="form-field">
            <?php 
                echo Form::label('tags', 'Tags'); 
                echo Form::input('tags[]', 'Food', array('class' => 'input'));
             ?>
        </div>
        */?>
    </div>
    
    <? /*
    Venue ID: <?php echo $venue['id'] ?><br/>
    <?php echo $venue['name'] ?><br/>
    <?php echo $venue['address_1'] ?><br/>
    <?php echo $venue['address_2'] ?><br/>
    <?php echo $venue['city'] ?>, <?php echo $venue['state_province'] ?> <?php /* echo $venue['zip'] */ ?>

    <div class="form-field">
        <div class="input"><?php echo Form::button('save', (empty($event)) ? 'Create' : 'Edit'.' Event', array('type' => 'submit')); ?></div>
    </div>
    

<?php echo Form::close() ?>

</div>

<script>
$(function() {
    (function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});

                            // @TODO: bind this by event!
                            var event_name = $('#event_name');
                            if (event_name.val().length < 1)
                            {
                                event_name.val('A Night at '+ui.item.value);
                            }
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( "<button>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return false;
						}

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();

                        return false;
					});
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

    $( "#venues_combobox" )
        .combobox();

    //$("#venues_combobox")
    //    .bind( "autocompleteselect", function(event, ui) {
    //            console.log(ui.value);
    //        });

    $( "#toggle" ).click(function() {
        $( "#venues_combobox" ).toggle();
    });

    
    $('button, input:submit, a.button').button();

    // datetime
    //$('#datetime').val();

    var DateTimePicker = function(field_id)
    {
        this.el       = $('#'+field_id);
        this.datetime = new Date();

        this.datetime.setHours(19);
        this.datetime.setMinutes(30);
        this.datetime.setSeconds(00);
    }

    DateTimePicker.pad = function(val, length) {
        val = val.toString();
        while (val.length != length) 
        {
            val = '0' + val;
        }
        //console.log(val);
        return val;
    }

    DateTimePicker.prototype = {
        "_update_field" : function() {
            var fmt_datetime = this.datetime.getFullYear() + '-' +
                               DateTimePicker.pad(parseInt(this.datetime.getMonth(), 10) + 1, 2) + '-' +
                               DateTimePicker.pad(this.datetime.getDate(), 2) + ' ' +
                               DateTimePicker.pad(this.datetime.getHours(), 2) + ':' +
                               DateTimePicker.pad(this.datetime.getMinutes(), 2) + ':' +
                               DateTimePicker.pad(this.datetime.getSeconds(), 2);

            //console.log(this.datetime, fmt_datetime);

            this.el.val(fmt_datetime);
        },

        "set_time" : function(time) {
            time    = time.split(':'); 
            this.datetime.setHours(time[0]);
            this.datetime.setMinutes(time[1]);
            this.datetime.setSeconds(0);

            this._update_field();
        },

        "set_date" : function(curr_date) {
            curr_date = curr_date.split('/');

            this.datetime.setMonth(parseInt(curr_date[0], 10) - 1);
            this.datetime.setDate(parseInt(curr_date[1], 10));
            this.datetime.setFullYear(parseInt(curr_date[2], 10));

            this._update_field();
        }
    };

    var dt_picker = new DateTimePicker('datetime');

    $('#timepicker').bind('change', function() {
        dt_picker.set_time($(this).val());
    });

    var datepicker = $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        showButtonPanel: true,
        onSelect: function(dateText, inst) {
            dt_picker.set_date(dateText);
        },
        //showOn: "button",
        //buttonImage: "http://jqueryui.com/demos/datepicker/images/calendar.gif",
        //buttonImageOnly: true
        
    });

    var event_form_accordian = $("#event_form").accordion({
            "header" : "h3",
            "autoHeight" : false 
        }),
        
    workflow_next = function() {
            var content_container_index = parseInt(this.href.split('#/')[1], 10);
            event_form_accordian.accordion("activate", content_container_index);
            //console.log(content_container_index);
            //event_form_accordian.activate(content_container_index);

            return false;
        };

    //console.log(event_form_accordian);

    $('a.button-workflow-next').live('click', workflow_next);

        
});
</script>
    

