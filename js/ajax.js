function print_monthly_report(url)
{
    var formData = new FormData($('form#frm_print')[0]);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) 
        {
            console.log(data);

            data = JSON.parse(data);

            if (data['msg'] == 'Success') 
            {
                var filename = data['file_name'];
                window.open(filename);
            } 
        }
    });
}

function tenants_sales_report(url)
{
    var formData = new FormData($('form#frm_print')[0]);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) 
        {
            // alert(url);
            console.log(data);

            data = JSON.parse(data);

            if (data['msg'] == 'Success') 
            {
                var filename = data['file_name'];
                window.open(filename);
            } 
        }
    });
}

function fixed_sales_report(url)
{
    var formData = new FormData($('form#frm_print')[0]);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) 
        {
            // alert(url);
            console.log(data);

            data = JSON.parse(data);

            if (data['msg'] == 'Success') 
            {
                var filename = data['file_name'];
                window.open(filename);
            } 
        }
    });
}

function upload_sales(url)
{   

    var formData = new FormData($('form#frm_upload')[0]);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function()
        {
            $('.loading-screen').show();
        },
        success: function(result)
        {
            $('.loading-screen').hide();
            console.log(result);
            //result = JSON.parse(result);
            display(result.type, result.msg, false, () => {
                $('form#frm_upload input[type=file]').val('');
            });
        },
    });

}

function archive_dailysales(url)
{
    var formData = new FormData($('form#confirm_archive')[0]);

  
    return new Promise((resolve, reject) => {
        
        $.ajax({
            type:'POST',
            url: url,
            data: formData,
            enctype: 'multipart/form-data',
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function()
            {
                $('.loading-screen').show();
            },
            success: function(data)
            {
                $('.loading-screen').hide();
                $('#confirm_archive').modal('hide')
                resolve(data);
            },
        });
    });
    
}

function archive_hourlysales(url)
{
    var formData = new FormData($('form#confirm_archive')[0]);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function()
        {
            $('.loading-screen').show();
        },
        success: function(data)
        {
            $('.loading-screen').hide();
            // alert("asd");
            console.log(data);
            data = JSON.parse(data);
            
            if (data['msg'] == 'Success')
            {
                display('success', 'Successfuly archived.');
            }
            else if (data['msg'] == 'Error')
            {
                display('warning', 'Error. Call Admin.');
            }
            else if (data['msg'] == 'Not Confirmed')
            {
                display('warning', 'Data not yet Confirmed');
            }
            else if (data['msg'] == 'No Data')
            {
                display('warning', 'No Data');
            }else
            {
                display('warning', 'Error');
            }

        },
    });
}

function load_confirm_hourlysales(url)
{
    var formData = new FormData($('form#frm_updatehourly')[0]);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function()
        {
            $('.loading-screen').show();
        },
        success: function(data)
        {
            $('.loading-screen').hide();
            // alert("asd");
            console.log(data);
            data = JSON.parse(data);
            
            if (data['msg'] == 'Success')
            {
                display('success', 'Successfuly Updated.');
            }
            else if (data['msg'] == 'No File')
            {
                display('warning', 'No File');
            }
            else if (data['msg'] == 'Data Not Checked')
            {
                display('warning', 'Data not Checked');
            }
            else if (data['msg'] == 'Already Checked')
            {
                display('warning', 'Data Already Checked.');
            }else
            {
                display('warning', 'Error');
            }

        },
    });
}

function load_confirm_unhourlysales(url)
{
    var formData = new FormData($('form#frm_updateunhourly')[0]);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: url,
        data: formData,
        enctype: 'multipart/form-data',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function()
        {
            $('.loading-screen').show();
        },
        success: function(data)
        {
            $('.loading-screen').hide();
            // alert("asd");
            console.log(data);
            data = JSON.parse(data);
            
            if (data['msg'] == 'Success')
            {
                display('success', 'Successfuly Updated.');
            }
            else if (data['msg'] == 'No File')
            {
                display('warning', 'No File');
            }
            else if (data['msg'] == 'Already Checked')
            {
                display('warning', 'Data Already Checked.');
            }else
            {
                display('warning', 'Error');
            }

        },
    });
}