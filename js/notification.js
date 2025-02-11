function generate(type, text) 
{
    var n = noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        layout      : 'topRight',
        closeWith   : ['click'],
        theme       : 'relax',
        timeout     : 3000,
        maxVisible  : 1,
        animation   : {
            open  : 'animated slideInDown',
            close : 'animated slideOutRight',
            easing: 'swing',
            speed : 500
        }
    });
    console.log('html: ' + n.options.id);
}

function generate1(type, text) 
{
    var n = noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        layout      : 'center',
        closeWith   : ['click'],
        theme       : 'relax',
        timeout     : 5000,
        maxVisible  : 1,
        animation   : {
            open  : 'animated slideInDown',
            close : 'animated slideOutRight',
            easing: 'swing',
            speed : 500
        }
    });
    console.log('html: ' + n.options.id);
}

function display(type, text, reload = true, callback = ()=>{})
{


    var n = noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        layout      : 'center',
        focus       : true,
        modal       : true,
        theme       : 'defaultTheme',
        buttons     : [
            {addClass: 'btn btn-primary', text: 'Close', onClick: function ($noty)
                {   

                    $noty.close();

                    callback();
                    
                    if(reload)
                        location.reload();


                    //noty({dismissQueue: true, force: true, layout: 'center', theme: 'defaultTheme'});
                }
            }
        ]
    });
    document.getElementById('button-0').focus(); 
    console.log('html: ' + n.options.id);
}


(function(win){
    var pop = {};

    pop.confirm =  function(settings = {}){
        settings = typeof settings == 'object' ? settings : {};

        var title               = settings.title || `<i class="fa fa-warning"></i> Confirm`;
        var message             = settings.message || 'Please confirm to proceed!';

        success                 = settings.success || {};
        success.class           = success.class || 'btn-info';
        success.text            = success.text || `<i class="fa fa-check"></i> Confirm`;

        cancel                  = settings.cancel || {};
        cancel.class            = cancel.class || 'btn-primary';
        cancel.text             = cancel.text || `<i class="fa fa-close"></i> Cancel`;

        
        $('#pop-confirmation').modal('show');
        $('#pop-confirm-title').html(title);
        $('#pop-confirm-message').html(message);

        
        $('#pop-confirm-positive').html(success.text);
        $("#pop-confirm-positive").removeAttr('class');
        $('#pop-confirm-positive').addClass(`btn ` + success.class);

        $('#pop-confirm-negative').html(cancel.text);
        $("#pop-confirm-negative").removeAttr('class');
        $('#pop-confirm-negative').addClass(`btn ` + cancel.class);

        return new Promise((resolve, reject) => {
            pop.resolve =  resolve;
            pop.reject = reject;         
        })
    }

    win.pop = pop;
})(window)
