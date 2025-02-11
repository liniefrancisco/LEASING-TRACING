function groupArrayByDate(arr_data, col, format = 'month', sort = 'ASC'){

    var regex = ( format == 'year' ?  /^\d{4}/g :
        (format == 'month' ? /^\d{4}\-(0[1-9]|1[012])/g : 
            (format == 'day' ? /^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/g :
                 /^.{1,50}$/g
            )
        )
    );

    arr_data.sort((a,b) => (a[col] > b[col]) ? (sort == 'ASC' ? 1 : -1) : ((b[col] > a[col]) ? (sort == 'ASC' ? -1 : 1) : 0));

    let grouped = {};

    arr_data.forEach((data)=>{

        let group_name = '';

        if(data[col].match(regex)){
            group_name = data[col].match(regex)[0];
        }
        else{
            group_name = data[col];
        }

        if(!grouped[group_name]) grouped[group_name] = [];

        grouped[group_name].push(data);

    })

    return grouped;
}

var _scope = null;


var app=angular.module('app',['720kb.datepicker', 'ui.mask','ui.utils.masks','chart.js', 'rw.moneymask']);


app.filter('offset', function() {
    return function(input, start) {
        if (!input || !input.length) { return; }
        start = +start; //parse to int
        return input.slice(start);
    }
});

app.filter('currentdate',['$filter',  function($filter) {
    return function() {
        return $filter('date')(new Date(), 'dd-MM-yyyy');
    }
}]);

app.filter('split', function() {
    return function(input, splitChar, splitIndex) {
        // do some bounds checking here to ensure it has that index
        return input.split(splitChar)[splitIndex];
    }
});


app.filter('arrayTotal', ()=>{
    return function(dataList, index) {
        //console.log(dataList);
        var calculated = 0;

        dataList.forEach((data)=>{
            console.log();
            calculated += Number(data[index]);
        })

        return calculated;
    }
})

app.filter('toKebabCase', function() {
    return toKebabCase;
});

app.filter('toNumber', function() {
    return function(data)
    {
        data = data.replace(/,/g , "");
        data = parseFloat(data);
        return data;
    }
});



app.filter('numberFormat', function() {
    return function(number, precision = 2, currency = '') {
        number1     = parseFloat(number) || 0;
        precision   = parseInt(precision) || 2;

        var data = isNaN(number) ? number :  number1.toFixed(precision).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        data = currency.length > 0 ? `${currency} ${data}` : data;

        return data;
    }
});


app.filter('groupArrayByDate', function() {
    return groupArrayByDate;
});









app.controller('decontroller',function($scope,$http)
{    
    
    $_scope = $scope;

    $scope.dateOptions = {
    formatYear: 'yyyy',
    startingDay: 1,
    minMode: 'year'
    };

    $scope.hourly_hide = true;
    $scope.daily_hide = false;

    $scope.mode = 1;

    $scope.typeof = (data)=>{
        return typeof data;
    }

    $scope.$base_url = $base_url;

    $scope.ajaxPost = (url, data = {}, message = '')=>{
        console.log(url);


        return new Promise((resolve, reject)=>{


            pop.confirm({
                title : 'Confirm Submission',
                message : message.length == 0 ? 'Do you wish to continue this action?' : message,
                success : {
                    text : 'Yes, Continue'
                }
            }).then((rs)=>{
                if(!rs){
                    reject("Action rejected");
                    return;
                }

                if(typeof data == "string")
                    data = $("#"+data).serializeObject();

                $.post({url : url, data : data}).done(function(result){
                    display(result.type, result.msg, false);
                    console.log(result);
                    resolve(result);
                })
            })
            
        })
    }

    $scope.dashboardData = {};
    $scope.getDashboardData = (url) => {
        $http.get(url).success(function(result){
           $scope.dashboardData = result;
           console.log(result);
        });
    }

    $scope.lastList = '';
    $scope.getDataList  = (url = '', list = '') => {
        $scope.lastUrl = url;
        $scope.lastList = list.length == 0 ? $scope.lastList : list;

        console.log(url);

        $http.get(url).success(function(result){
           $scope[$scope.lastList] = result;
            console.log(result);
        });
    }

    $scope.sendAjax = (url, message='',  func_name ='')=>{

        pop.confirm({
            title : 'Confirm',
            message : message.length == 0 ? 'Do you wish to continue this action?' : message,
            success : {
                text : 'Continue'
            }
        }).then((rs)=>{
            if(!rs)
                return;

            $.post({url : url, dataType: 'json'}).done(function(result){
                display(result.type, result.msg, false);
                console.log(result);
                if(result.type == 'success' && func_name != ''){
                    $scope[func_name]($scope.lastUrl);
                }

            })
        }) 
    }

    $scope.clearUserSetting = ()=>{
        $("form[name=password_form]")[0].reset()
        $("form[name=username_form]")[0].reset()
    }

    $scope.formSubmit = (url, e, func_name ='', modal = '', message='')=>{
        e.preventDefault();

        pop.confirm({
            title : 'Confirm Submission',
            message : message.length == 0 ? 'Do you wish to continue this action?' : message,
            success : {
                text : 'Yes, Continue'
            }
        }).then((rs)=>{
            if(!rs)
                return;
            var data = $(e.target).serializeObject();

            console.log(data);

            $.post({url : url, data : data, dataType: 'json'}).done(function(result){
                display(result.type, result.msg, false);
                console.log(result);
                if(result.type == 'success' ){
                    if(modal != '')
                        $(modal).modal('hide');
                    if(func_name != '')
                        $scope[func_name]($scope.lastUrl);
                    
                }

            })
        })
       
    }



    $scope.ajaxDelete = (url, data = {}, message = '')=>{
        console.log(url);


        return new Promise((resolve, reject)=>{


            pop.confirm({
                title : 'Confirm Delete',
                message : message.length == 0 ? 'Are you sure you want to delete this data?' : message,
                success : {
                    text : '<i class="fa fa-trash"></i> Delete',
                    class : 'btn-danger'
                }
            }).then((rs)=>{
                if(!rs){
                    reject("Action rejected");
                    return;
                }

                if(typeof data == "string")
                    data = $("#"+data).serializeObject();

                console.log(data);

                $.post({url : url, data : data, dataType: 'json'}).done(function(result){
                    display(result.type, result.msg, false);
                    console.log(result);
                    resolve(result);
                })
            })
            
        })
       
    }

    $scope.hourly_daily_option = function(url)
    {   
        $scope.hourly_hide = false;
        $scope.daily_hide = true;
    }   

    $scope.daily_hourly_option = function(url)
    {
        $scope.hourly_hide = true;
        $scope.daily_hide = false;
    }  
    $scope.dataList= [];
    $scope.loadList = function(url)
    {
        $scope.lastUrl = url;
        $scope.status;
        $http.post(url).success(function(result){
            $scope.dataList=result;
            console.log(result);
        });
    }

    $scope.stores= [];
    $scope.getStores = function(url)
    {
        $http.get(url).success(function(result){
           $scope.stores=result;
            console.log(result);
        });
    }



    $scope.pending_hourly= [];
    $scope.pendingList_hourly = function(url)
    {
        $scope.status;
        $http.post(url).success(function(result){
            $scope.pending_hourly=result;
            console.log(result);
        });
    }

    $scope.input_list= [];
    $scope.input_loadList = function(url)
    {
        $scope.lastUrl = url;

        $http.post(url).success(function(result){
            $scope.input_list=result;
            console.log(result);
        });
    }

    $scope.updateVariance = (url, e)=>{
        e.preventDefault();

        var data = $(e.target).serializeObject();

         pop.confirm({
            title : 'Submit',
            message : 'Are you sure you want to continue submitting this data?',
            success : {
                text : `<i class="fa fa-check"></i> Continue`,
            }
        }).then(function(result){
            if(result == true){
                $.post({
                    url: url,
                    data: data,
                    success: (result) => {
                        display(result.type, result.msg, false);

                        if(result.type == 'success'){
                            $scope.input_loadList($scope.lastUrl);
                            $('#variance_report').modal('hide');
                        }
                    } 
                })
            }
        });
    }

    $scope.submitInputSales = (url, e)=>{
        e.preventDefault();



        var data = $(e.target).serializeObject();

        pop.confirm({
            title : 'Submit',
            message : 'Are you sure you want to continue submitting this data?',
            success : {
                text : `<i class="fa fa-check"></i> Continue`,
            }
        }).then(function(result){
            if(result == true){
                $.post({
                    url: url, 
                    data :data,
                    success : (result)=>{
                        display(result.type, result.msg, false);

                        if (result.type == 'success') {
                            $scope.input_loadList($scope.lastUrl);
                            $('#input_sales_data').modal('hide');
                            $scope.tenant_list              = null;
                            $scope.trade_name               = null;
                            $scope.location_code            = null;
                            $scope.rental_type              = null;
                            $scope.total_gross_sales        = null;
                            $scope.total_netsales_amount    = null;
                            $scope.date                     = null;
                        }
                    },
                });
            }
        });
    }

    $scope.input_varlist= [];
    $scope.input_varList = function(url)
    {
        $http.post(url).success(function(result){
            $scope.input_varlist=result;
            console.log(result);
        });
    }

    $scope.pendingList= [];
    $scope.loadPending = function(url)
    {
        $http.post(url).success(function(result){
            $scope.pendingList=result;
            console.log(result);
        });
    }


    $scope.hourlyHistory= [];
    $scope.loadHourly = function(url)
    {
        $http.post(url).success(function(result){
            $scope.hourlyHistory=result;
            console.log(result);
        });
    }

    $scope.dailyHistory= [];
    $scope.loadDaily = function(url)
    {
        $http.post(url).success(function(result){
            $scope.dailyHistory=result;
            console.log(result);
        });
    }

    $scope.getHourlySales = ()=>{
        var url = $base_url  + `index.php/tsms_controller/get_hourly_sales`;

        $http.get(url).success((result)=>{
            $scope.hourlyList=result;
            console.log(result);
        })
    }

    $scope.hourlyList= [];
    $scope.hourlyInit = function(url)
    {
        $http.post(url).success(function(result){
            $scope.hourlyList=result;
            console.log(result);
        });
    }


    $scope.hasSelectedHourlySale = ($status = 'Unconfirmed')=>{
        $length = $scope.viewData.filter(function(hs){
            return hs.status ==  $status && hs.selected;
        }).length;


        return $length > 0;

    }

    $scope.confirm_hourlysales = (e)=>{
        e.preventDefault();

        var url = $base_url + `tsms_controller/update_hourly_sales_record`;
        pop.confirm({
            message : 'Do you wish to confirm the selected hourly sales?',
        }).then((result)=>{
            if(!result) return;

            var formData = {'checkboxes' : $scope.viewData.filter(function(dt){
                return dt.status == 'Unconfirmed' && dt.selected;
            }).map(function(dt){
                return  dt.id;
            })};


            $.post({
                url: url,
                data: formData,
                dataType : 'json',
                beforeSend:function()
                {
                    $('.loading-screen').show();
                },
                success: function(result)
                {
                    $('.loading-screen').hide();
                    display(result.type, result.msg, false);
                    
                    $scope.getHourlySales();
                    $scope.viewSales($scope.lastUrl, $scope.lastData);
                  
                },
            });

          
        })
    }

    $scope.archive_hourlysales = () => {

        pop.confirm({
            title : 'Archive Hourly Sales',
            message : `Do you wish to archive confirmed hourly sales?`,
            success : {
                text : `<i class="fa fa-archive"></i> Archive`,
                class: `btn-success`
            }
        }).then((result)=>{
            if(!result) return;

            var url = $base_url+ `index.php/tsms_controller/archive_hourly_sales`;
            $.post({
                type:'POST',
                url: url,
                dataType : 'json',
                beforeSend: ()=>{
                    $('.loading-screen').show();
                },
                success: (result) => {      
                    $('.loading-screen').hide();

                    display(result.type, result.msg, false);

                    if(result.type == 'success'){
                        $scope.getHourlySales();
                    }               
                },
            });
        })
    }

    $scope.upload_sales = (url, e)=>{   
        e.preventDefault();
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
            dataType: 'json',
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
    $scope.textFiles = [];

    $scope.clearFiles = ()=>{
        $scope.textFiles = [];
        $('#files').val(null);

    }

    $scope.removeFile = (index)=>{
        $scope.textFiles.splice(index, 1);
    }

    $scope.addFiles = (form)=> {
        var input = $(form);

        $.each(input, function (obj, v) {
            var files = v.files;
            if(!files || files.length == 0)
                return;

            $.each(files, (key, file)=>{
                console.log(key,file);
                $scope.textFiles.push(file);
            })
        });
    }

    $scope.viewDetails = (details)=>{

        if(isEqual($scope.details, details))
            $('#details').collapse("toggle");

        $scope.details = details;
        console.log(details);
    }

    $scope.uploadMultiSales = (url, e)=>{   
        e.preventDefault();
        var formData = new FormData($('form#frm_upload')[0]);

        $scope.textFiles.forEach((file)=>{
            formData.append('files[]', file, file.name);
        })

        $.ajax({
            type:'POST',
            url: url,
            data: formData,
            enctype: 'multipart/form-data',
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend:function()
            {
                $('.loading-screen').show();
            },
            success: function(result)
            {
                $('.loading-screen').hide();
                console.log(result);
                //result = JSON.parse(result);

                if(result.errors || result.success){
                    $scope.result = result;
                    $('#result_dialog').modal('show'); 
                }
                else{
                     display(result.type, result.msg, false);
                } 
                if(result.type == 'success')
                    $scope.clearFiles();

               //$('form#frm_upload input[type=file]').val('');
            },
           
        });
    }

    $scope.uploadData_List= [];
    $scope.uploadData = function(url)
    {   
        $scope.lastUrl = url;
        $http.post(url).success(function(result){
            $scope.uploadData_List=result;
            console.log(result);
        });
    }

    $scope.uploadForLeasing = (url, e)=>{
        e.preventDefault();
        $scope.ajaxPost(url).then((result)=>{
            if(result.type == "success"){
                $("#confirmation_modal_upload").modal("hide");
                $scope.uploadData($scope.lastUrl);
            }
        });
    }

    $scope.updateDataForLeasing = (url, e) => {
        e.preventDefault();

        var data = $(e.target).serializeObject();
        console.log(data);
        $scope.ajaxPost(url, data).then((result)=>{
            if(result.type=="success"){
                $("#update_modal_daily").modal("hide");
                $scope.uploadData($scope.lastUrl);
            }
                
        })
    }

    $scope.deleteDataForLeasing = (url) =>{
        $scope.ajaxDelete(url, {}, 'Are you sure you want to delete this data?').then((result)=>{
            console.log(result);
            if(result.type=="success"){
                $scope.uploadData($scope.lastUrl);
            }   
        })
    }

    $scope.unhourlyList= [];
    $scope.unhourlyInit = function()
    {   
        var url = $base_url + 'tsms_controller/get_unhourly_sales/';
        $http.post(url).success(function(result){
            $scope.unhourlyList=result;
            console.log(result);
        });
    }

    $scope.confirm_unmatched_hourlysales = (e)=>{
        e.preventDefault();

        var url = $base_url + `tsms_controller/update_hourly_sales_record`;
        pop.confirm({
            message : 'Do you wish to confirm the selected hourly sales?',
        }).then((result)=>{
            if(!result) return;

            var formData = {'checkboxes' : $scope.viewData.filter(function(dt){
                return dt.status == 'Unmatched' && dt.selected;
            }).map(function(dt){
                return  dt.id;
            })};

            $.post({
                url: url,
                data: formData,
                dataType : 'json',
                beforeSend:function()
                {
                    $('.loading-screen').show();
                },
                success: function(result)
                {
                    $('.loading-screen').hide();
                    display(result.type, result.msg, false);

                    if(result.type == 'success'){
                        $scope.unhourlyInit();
                        $scope.viewSales($scope.lastUrl, $scope.lastData);
                    }
                },
            });

          
        })
    }



    $scope.disHourList= [];
    $scope.disHourInit = function(url)
    {
        $http.post(url).success(function(result){
            $scope.disHourList=result;
            console.log(result);
        });
    }

     $scope.disDayList= [];
    $scope.disDayInit = function(url)
    {
        $http.post(url).success(function(result){
            $scope.disDayList=result;
            console.log(result);
        });
    }

    $scope.match_sales = function(url)
    {
        $scope.total_net_sales;
        $scope.total_sales_transaction;
        $scope.total_customer_count;
        $scope.total_netsales_amount;
        $http.post(url).success(function(result){
            console.log(result);
                    
                $scope.total_net_sales=(result[0].total_net_sales);
                $scope.total_sales_transaction=(result[0].total_sales_transaction);
                $scope.total_customer_count=(result[0].total_customer_count);
                $scope.total_netsales_amount=(result[0].total_netsales_amount);
                    
                
            console.log(result);
        });
    }
    $scope.getDailySales = ()=>{
        var url = $base_url + `index.php/tsms_controller/get_daily_sales`;
        $http.post(url).success(function(result){
            $scope.dailyList=result;
            console.log(result);
        });
    }

    $scope.dailyList= [];
    $scope.dailyInit = function(url)
    {
        $http.post(url).success(function(result){
            $scope.dailyList=result;
            console.log(result);
        });
    }

    $scope.undailyList= [];
    $scope.undailyInit = function(url)
    {
        $scope.lastUrl = url;
        $http.post(url).success(function(result){
            $scope.undailyList=result;
            console.log(result);
        });
    }


    $scope.delete_unmatched_daily_sale = (id)=>{
        var url = $base_url + 'index.php/tsms_controller/delete_daily_sales/' + id;

        pop.confirm({
            message : 'Do you realy want to delete this data?',
            success : {
                text : `<i class="fa fa-trash"></i> Delete`,
                class : `btn-danger`
            }
        }).then(function(result){
            if(result == true){
                $http.post(url).success(function(result){
                    display(result.type, result.msg, false);

                    if (result.type == 'success') {
                        $scope.undailyInit($scope.lastUrl);
                    }
                });
            }
        });
    }

    $scope.confirm_unmatched_daily_sale = (id, e) =>{
        e.preventDefault();
        var data = $(e.target).serializeObject();

        var url = $base_url + `tsms_controller/update_daily_sales/` + id;

        pop.confirm({message: "Do you want to proceed confirming daily sale record?"}).then((result)=>{

            if(result){

                $.post({
                    url : url,
                    data : data,
                    dataType:'json', 
                    success : (result)=>{
                        display(result.type, result.msg, false);

                        if(result.type == 'success'){
                            $scope.undailyInit($scope.lastUrl);
                            $('#update_modal_daily').modal('hide');
                        }
                    }
                })
            }
        });
    }


    $scope.archive_dailysales = ()=>{

        var url = $base_url + 'index.php/tsms_controller/archive_daily_sales';
        pop.confirm({
            message : `Do you really want to archive all confirmed daily sales record?`,
            confirm : {
                class : `btn-warning`,
            }
        }).then((result)=>{
            if(result){
                $.post({
                    dataType : 'json',
                    url: url,
                    beforeSend:function()
                    {
                        $('.loading-screen').show();
                    },
                    success: function(res)
                    {
                        display(res.type, res.msg, false);
                        $('.loading-screen').hide();
                        $('#confirm_archive').modal('hide')
                        
                        if (res.type == 'success')
                            $scope.getDailySales();
                       
                    },
                });
            }
        })
    }

    $scope.confirm_daily_sale = (id, e) =>{
        e.preventDefault();
        var data = $(e.target).serializeObject();

        var url = $base_url + `tsms_controller/update_daily_sales/` + id;

        pop.confirm({message: "Do you want to proceed confirming daily sale record?"}).then((result)=>{
            if(result){
                $.post({
                    url : url,
                    data : data,
                    dataType:'json', 
                    success : (result)=>{
                        display(result.type, result.msg, false);

                        if(result.type == 'success'){
                            $scope.getDailySales();
                            $('#update_modal_daily').modal('hide');
                        }
                    }
                })
            }
        });
    }

    $scope.delete_daily_sale = (id)=>{
        var url = $base_url + 'index.php/tsms_controller/delete_daily_sales/' + id;

        pop.confirm({
            message : 'Do you realy want to delete this data?',
            success : {
                text : `<i class="fa fa-trash"></i> Delete`,
                class : `btn-danger`
            }
        }).then(function(result){
            if(result == true){
                $http.post(url).success(function(result){
                    display(result.type, result.msg, false);

                    if (result.type == 'success') {
                            $scope.getDailySales();
                    }
                });
            }
        });
    }

    $scope.yearlySales = [];
    $scope.getYearlySales = (url, e)=>{
        e.preventDefault();

        $http.get(url).success(function(result){
            $scope.yearlySales=result;
            console.log(result);
        });
    }

    

    $scope.data = {};
    $scope.setData = (data)=>{
        $scope.data =   JSON.parse(JSON.stringify(data)); 
    }

    $scope.selected = [];

    $scope.exist = function(item){
        return $scope.selected.indexOf(item) > -1;
    }

    $scope.toggleSelection = function(item){

        var idx = $scope.selected.indexOf(item);
        if(idx > - 1){
            $scope.selected.splice(idx, 1);
        }else{
            $scope.selected.push(item);
        }
        console.log($scope.selected);
    }

    $scope.checkAll = function()
    {
        var checkboxes = document.getElementsByName('checkboxes[]');
        var checkboxesChecked = [];
        
        for(var i=0; checkboxes[i]; ++i){
            if(checkboxes[i].checked){
                checkboxesChecked.push(checkboxes[i].value);
            }
        }
        console.log(checkboxesChecked);
    
    }
   
    $scope.allSelected = function(name) {

        var selected = $scope[name].filter(function(dt){
            return dt.selected == true;
        }).length;

        return selected == $scope[name].length;
    }

    $scope.selectAll = (name, e) => {
      
        var checked = $(e.target).prop('checked')   

        $scope[name].forEach(function(dt){
            dt.selected = checked;
        });

        
    }

     $scope.update = function(url)
    {
         // alert(url);
        $scope.updateData=[];
        $http.post(url).success(function(result){
            $scope.updateData=result;
            console.log(result);
        });
    }

    $scope.viewData = [];
    $scope.viewSales = function(url, data)
    {   
        $scope.lastData = data;
        $scope.lastUrl = url;

        $scope.viewData=[];

        $http({
            method: 'POST',
            url: url,
            data: $.param( data ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(result){
            console.log(result);
            $scope.viewData=result;
        });
    }


    $scope.viewDis = function(url)
    {
         // alert(url);
        $scope.disData=[];
        $http.post(url).success(function(result){
            $scope.disData=result;
        
            console.log(result);
        });
    }

    $scope.getTenants = function(url)
    {   
        $scope.trade_name       = null;
        $scope.location_code    = null;
        $scope.rental_type      = null;

        $scope.tenantlist = [];
        $http.post(url).success(function(result){
            $scope.tenantlist=result;
            console.log(result);
        });
    }

    $scope.getLocation = function(url)
    {
        // alert(url);
        $scope.location_code    = null;
        $scope.rental_type      = null;

        $scope.locationcode = [];
        $http.post(url).success(function(result){
            $scope.locationcode=result;
            $scope.locations = result;
            console.log(result);

            $scope.location_code    = result[0].location_code;
            $scope.rental_type      = result[0].rental_type;

            $scope.getRental();
        });
    }

    $scope.getRental = function()
    {
        $scope.rental_type      = null;

        $scope.rent = [];

        var url = $base_url + 'tsms_controller/get_rental_type/' + $scope.location_code;

        $http.post(url).success(function(result){
            $scope.rent=result;
            $scope.rental_type = result.length > 0 ? result[0].rental_type : null;
            console.log(result);
        });
    }

      $scope.tenants_daily = function(url)
    {
        $scope.tenantListD = [];
        $http.post(url).success(function(result){
            $scope.tenantListD=result;
            console.log(result);
        });
    }

    $scope.tenant_sales_type= function(url)
    {
        $scope.sales;
        $scope.hide_button;
        $scope.sales_type;

        $http.post(url).success(function(result){
            var sales_type = result.match(/(?:"[^"]*"|^[^"]*$)/)[0].replace(/"/g, "");

            alert("Rentable Sales Type: "+sales_type);
            console.log(result);
            $scope.asd = sales_type;
        });
        $scope.hide_button = true;
    }

    $scope.tenants_hourly = function(url)
    {
        $scope.tenantListH = [];
        $http.post(url).success(function(result){
            $scope.tenantListH=result;
            console.log(result);
        });
    }

     $scope.asd = function(url)
    {
        alert(url);
        $http.post(url).success(function(result){
            console.log(result);
        });
    }


    $scope.toNumber = function(data)
    {
        data = data.replace(/,/g , "");
        data = parseFloat(data);
        return data;
    }

    $scope.filterby_hour = function(url)
    {   
        // alert(url);
        $scope.filterdata_hourly = [];
        $scope.rental_type;
        $scope.tenant_type;
        $scope.trade_name;
        $scope.pos_num;
        $scope.tenant_code;
        $scope.control_num;
        $scope.sales_type;
        $scope.transac_date;
        $scope.tenant_type_code;
        $scope.netsales_amount_hour=0;
        $scope.totalnetsales_amount_hour=0;
        $scope.totalnumber_sales_transac=0;
        $scope.customer_count_hour=0;
        $scope.numsales_transac_hour=0;
        $scope.total_customer_count_day=0;

        $http.post(url).success(function(result){

            var hourly  = result.hourly;
            var daily   = result.daily;

            $scope.filterdata_hourly= hourly;

            if(daily.length != 0)
            {   
                $scope.total_net_sales = 0;
                $scope.total_sales_transaction = 0;
                $scope.total_customer_count = 0;
                $scope.total_netsales_amount = 0;

                var daily_pos = []; 
                daily.forEach((dl)=>{
                    daily_pos.push(dl.pos_num);
                    $scope.total_net_sales          += parseFloat(dl.total_net_sales);
                    $scope.total_sales_transaction  += parseFloat(dl.total_sales_transaction);
                    $scope.total_customer_count     += parseFloat(dl.total_customer_count);
                    $scope.total_netsales_amount    += parseFloat(dl.total_netsales_amount);
                })

                $scope.pos_num_daily = daily_pos.join(', ');
               
            }
            
            if(hourly.length != 0)
            {   
                var grouped = groupBy(hourly, 'pos_num');

                $scope.pos_num              = Object.keys(grouped).join(', ');

                $scope.rental_type          = (hourly[0].rental_type);
                $scope.sales_type           = (hourly[0].sales_type);
                $scope.control_num          = (hourly[0].control_num);
                $scope.tenant_type_code     = (hourly[0].tenant_type_code);
                $scope.tenant_code          = (hourly[0].tenant_code);
                $scope.trade_name           = (hourly[0].trade_name);
                $scope.tenant_type          = (hourly[0].tenant_type);
                $scope.transac_date         = (hourly[0].transac_date);
                $scope.totalnumber_sales_transac    = parseFloat(hourly[0].totalnumber_sales_transac);
                $scope.total_customer_count_day     = parseFloat(hourly[0].total_customer_count_day);
                $scope.totalnetsales_amount_hour    = parseFloat(hourly[0].totalnetsales_amount_hour);

                for (var i = 0; i < hourly.length; i++) {
                    $scope.netsales_amount_hour     += parseFloat(hourly[i].netsales_amount_hour);
                    $scope.customer_count_hour      += parseFloat(hourly[i].customer_count_hour);
                    $scope.numsales_transac_hour    += parseFloat(hourly[i].numsales_transac_hour); 
                }
            }


            if(hourly.length != 0 && daily.length != 0){

                if( ($scope.netsales_amount_hour.toFixed(2) == $scope.total_netsales_amount) &&
                    ($scope.customer_count_hour == $scope.total_customer_count) &&
                    ($scope.numsales_transac_hour ==  $scope.total_sales_transaction) )
                    $scope.genStatus = 'Matched';

                else
                    $scope.genStatus = 'Not matched';

                console.log($scope.netsales_amount_hour, $scope.total_netsales_amount, ($scope.netsales_amount_hour == $scope.total_netsales_amount) ,
                    ($scope.customer_count_hour == $scope.total_customer_count) ,
                    ($scope.numsales_transac_hour ==  $scope.total_sales_transaction));
            }

            console.log(result);
        });
    }
    
    $scope.filterby_day = function(url)
    {   
        $scope.sales = '';

        $scope.rental_type;
        $scope.tenant_type;
        $scope.date;
        $scope.trade_name;
        $scope.pos_num;
        $scope.tenant_code;
        $scope.location_code;
        $scope.control_num;
        $scope.sales_type;
        $scope.tenant_type_code;
        $scope.old_acctotal         =0;
        $scope.new_acctotal         =0;
        $scope.total_gross_sales    =0;
        $scope.total_nontax_sales   =0;
        $scope.total_sc_discounts   =0;
        $scope.total_pwd_discounts  =0;
        $scope.total_discounts_w_approval   =0;
        $scope.total_discounts_wo_approval  =0;
        $scope.other_discounts              =0;
        $scope.total_refund_amount          =0;
        $scope.total_taxvat                 =0;
        $scope.total_other_charges          =0;
        $scope.total_service_charge         =0;
        $scope.total_net_sales              =0;
        $scope.total_cash_sales             =0;
        $scope.total_charge_sales           =0;
        $scope.total_gcother_values         =0;
        $scope.total_void_amount            =0;
        $scope.total_customer_count         =0;
        $scope.total_sales_transaction      =0;
        $scope.total_netsales_amount        =0;

        $http.post(url).success(function(result){
            $scope.filterdata = result;

            console.log(result);
            if(result.length != 0)
            {   
                var x = (result.length - 1);

                var grouped = groupBy(result, 'pos_num');

                console.log('grouped: ', grouped);

                var pos_num = '';
                Object.values(grouped).forEach((gp)=>{
                    $scope.old_acctotal += parseFloat(gp[gp.length - 1].old_acctotal);
                    $scope.new_acctotal += parseFloat(gp[gp.length - 1].new_acctotal);
                })

                $scope.pos_num          = Object.keys(grouped).join(', ');
                //console.log($scope.old_acctotal, $scope.new_acctotal);

                $scope.asd              = result[0].sales.match(/(?:"[^"]*"|^[^"]*$)/)[0].replace(/"/g, "");
                $scope.rental_type      = result[0].rental_type;
                $scope.sales_type       = result[0].sales_type;
                $scope.control_num      = result[0].control_num;
                $scope.tenant_type_code = result[0].tenant_type_code;
                $scope.tenant_code      = result[0].tenant_code;
                $scope.location_code    = result[0].location_code;
                $scope.trade_name       = result[0].trade_name;
                $scope.tenant_type      = result[0].tenant_type;
                $scope.date             = result[0].transac_date;
                $scope.location_code    = result[0].location_code;

                for (var i = 0; i < result.length; i++) {
                    
                    $scope.total_gross_sales            += parseFloat(result[i].total_gross_sales);
                    $scope.total_nontax_sales           += parseFloat(result[i].total_nontax_sales);
                    $scope.total_sc_discounts           += parseFloat(result[i].total_sc_discounts);
                    $scope.total_pwd_discounts          += parseFloat(result[i].total_pwd_discounts);
                    $scope.total_discounts_w_approval   += parseFloat(result[i].total_discounts_w_approval);
                    $scope.total_discounts_wo_approval  += parseFloat(result[i].total_discounts_wo_approval);
                    $scope.other_discounts              += parseFloat(result[i].other_discounts);
                    $scope.total_refund_amount          += parseFloat(result[i].total_refund_amount);
                    $scope.total_taxvat                 += parseFloat(result[i].total_taxvat);
                    $scope.total_other_charges          += parseFloat(result[i].total_other_charges);
                    $scope.total_service_charge         += parseFloat(result[i].total_service_charge);
                    $scope.total_net_sales              += parseFloat(result[i].total_net_sales);
                    $scope.total_cash_sales             += parseFloat(result[i].total_cash_sales);
                    $scope.total_charge_sales           += parseFloat(result[i].total_charge_sales);
                    $scope.total_gcother_values         += parseFloat(result[i].total_gcother_values);
                    $scope.total_void_amount            += parseFloat(result[i].total_void_amount);
                    $scope.total_customer_count         += parseFloat(result[i].total_customer_count);
                    $scope.total_sales_transaction      += parseFloat(result[i].total_sales_transaction);
                    $scope.total_netsales_amount        += parseFloat(result[i].total_netsales_amount);
                }
            }
            console.log(result);
        });
    }

    $scope.filter_monthlydata = null;
    $scope.data = {};
    $scope.get_monthly_sales = function(url, e)
    {   
        e.preventDefault();
        var dt = {
            'tenant_list'   : $scope.tenant_list,
            'location_code' : $scope.location_code,
            'year'          : $scope.year,
            'trade_name'    : $scope.tradename,
        }

        $scope.recorded_data = dt;

        $http({
            method: 'POST',
            url: url,
            data: $.param(dt),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success((result)=>{

            var data = {};
            data.old_acctotal=0;
            data.new_acctotal=0;
            data.total_gross_sales=0;
            data.total_nontax_sales=0;
            data.total_sc_discounts=0;
            data.total_pwd_discounts=0;
            data.total_discounts_w_approval=0;
            data.total_discounts_wo_approval=0;
            data.other_discounts=0;
            data.total_refund_amount=0;
            data.total_taxvat=0;
            data.total_other_charges=0;
            data.total_service_charge=0;
            data.total_net_sales=0;
            data.total_cash_sales=0;
            data.total_charge_sales=0;
            data.total_gcother_values=0;
            data.total_void_amount=0;
            data.total_customer_count=0;
            data.total_sales_transaction=0;
            data.total_netsales_amount=0;


            if(typeof result.type != 'undefined' && result.type == 'warning'){
                display('warning', result.msg, false);
                return;
            }

            $scope.filter_monthlydata = result;

            if(result.length != 0)
            {   
                data.tenant_code          = result[0].tenant_code;
                data.pos_num              = result[0].pos_num;
                data.control_num          = result[0].control_num;
                data.sales_type           = result[0].sales_type;
                data.tenant_type          = result[0].tenant_type;
                data.rental_type          = result[0].rental_type;
                data.trade_name           = result[0].trade_name;
                data.location_code        = result[0].location_code;
                data.tenant_type_code     = result[0].tenant_type_code;
                data.date_end             = result[0].date_end;

                for(var i = 0; i < result.length; i++)
                {
                  
                    data.old_acctotal         += parseFloat(result[i].old_acctotal);
                    data.new_acctotal         += parseFloat(result[i].new_acctotal);
                    data.total_gross_sales    += parseFloat(result[i].total_gross_sales);
                    data.total_nontax_sales   += parseFloat(result[i].total_nontax_sales);
                    data.total_sc_discounts   += parseFloat(result[i].total_sc_discounts);
                    data.total_pwd_discounts  += parseFloat(result[i].total_pwd_discounts);
                    data.other_discounts      += parseFloat(result[i].other_discounts);
                    data.total_refund_amount  += parseFloat(result[i].total_refund_amount);
                    data.total_taxvat         += parseFloat(result[i].total_taxvat);
                    data.total_other_charges  += parseFloat(result[i].total_other_charges);
                    data.total_service_charge += parseFloat(result[i].total_service_charge);
                    data.total_net_sales      += parseFloat(result[i].total_net_sales);
                    data.total_cash_sales     += parseFloat(result[i].total_cash_sales);
                    data.total_charge_sales   += parseFloat(result[i].total_charge_sales);
                    data.total_gcother_values += parseFloat(result[i].total_gcother_values);
                    data.total_void_amount    += parseFloat(result[i].total_void_amount);
                    data.total_discounts_w_approval   += parseFloat(result[i].total_discounts_w_approval);
                    data.total_discounts_wo_approval  += parseFloat(result[i].total_discounts_wo_approval);
                    data.total_customer_count         += parseFloat(result[i].total_customer_count);
                    data.total_sales_transaction      += parseFloat(result[i].total_sales_transaction);
                    data.total_netsales_amount        += parseFloat(result[i].total_netsales_amount);
                }
            }
            console.log(result);

            $scope.data = data;
        });
        
    }

    $scope.saveComputedYearlySale = (url, e) => 
    {
        e.preventDefault();

        var data = $scope.recorded_data;
        console.log(data);

        pop.confirm({
            message : 'Are you sure you want to save this computed yearly sale?',
            success : {
                text : `<i class="fa fa-check"></i> Save`,
            },
        }).then(function(result){
            if(result == true){
                //var data = $(e.target).serializeObject();
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: data,
                    dataType : 'json'
                }).done((result)=>{
                    console.log(result);
                    display(result.type, result.msg, false);
                    if(result.type == "success")
                        $('#calculate_modal_m').modal('hide');
                })            
            }
        });

        
    }
    $scope.discounts_w_approval = 0;
    $scope.calculate_m = function()
    {   
        var total_netsales_amount       = parseFloat($scope.total_netsales_amount);
        var total_gross_sales           = parseFloat($scope.total_gross_sales);
        var trade_name                  = $scope.trade_name;
        var total_nontax_sales          = parseFloat($scope.total_nontax_sales);
        var total_sc_discounts          = parseFloat($scope.total_sc_discounts);
        var discounts_w_approval        = parseFloat($scope.discounts_w_approval) || 0;
        var total_refund_amount         = parseFloat($scope.total_refund_amount);
   

        var vat = 0.12;
        var total=0;
        var sales="";

        
        var sales_type = $scope.asd;
        var sales=0;
        if(sales_type == 'GROSS')
        {
            total = total_gross_sales - Math.abs(total_refund_amount);

        }else if(sales_type == 'NET'){

            total = total_netsales_amount - Math.abs(total_refund_amount);

        }else if(sales_type == 'VATABLE SALES'){
            console.log(total_gross_sales, total_nontax_sales, discounts_w_approval);

            console.log(`SALES COMPUTATION:  ${total_gross_sales} - ${ total_nontax_sales } - ${discounts_w_approval } - ${ total_sc_discounts } - ${ total_refund_amount }`);
            sales = total_gross_sales - total_nontax_sales - discounts_w_approval ;
            total =  sales - total_sc_discounts - Math.abs(total_refund_amount);

        }else{
            display('warning', 'An error occured!', false);
        }

        $scope.sales = total;
        var rs = (total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        display('success', `Calculation complete!<br> Rentable Sale : <strong>₱ ${rs} </strong>`, false); 
    }

    $scope.monthly_total_button = function(url)
    {   
        $scope.lastUrl = url;
        $scope.monthly_total = [];
        $http.post(url).success(function(result){
            $scope.monthly_total=result;
            console.log(result);
        });
    }

    $scope.update_total_monthly_sale = (url, e)=>{
        e.preventDefault();

        pop.confirm({
            message : 'Are you sure you want to update this Monthly Sale Record?',
            success : {
                text : `<i class="fa fa-check"></i> Update`,
            },
        }).then(function(result){
            if(result == true){
                var data = $(e.target).serializeObject();
                $.post({
                    url:url, 
                    data: data, 
                    success : (result) =>{
                        display(result.type, result.msg, false);
                        if(result.type=="success"){
                            $scope.monthly_total_button($scope.lastUrl);
                            $('#update_modal_daily').modal('hide');
                        }
                    }
                });
            }
        });
    }

    $scope.fixed_total_button = function(url)
    {   
        // alert(url);
        $scope.monthly_total = [];
        $http.post(url).success(function(result){
            $scope.monthly_total=result;
            console.log(result);
        });
    }

    $scope.yearly_comparison_button = function(url)
    {   

        var get_year    = $scope.year;
        var get_year1   = $scope.year1;
        
        $scope.yearly_comparison = [];

        $http.post(url).success(function(result){
            $scope.yearly_comparison=result;
      
            console.log(result);
        });
    }

     $scope.search_pending_button = function(url)
    {   
        $scope.pending_items = [];
        $http.post(url).success(function(result){
            $scope.pending_items=result;
            console.log(result);
        });
    }

    $scope.for_approvement_button = function(url)
    {   
        alert(url);
        $scope.for_approvement = [];
        $http.post(url).success(function(result){
            $scope.for_approvement=result;
            console.log(result);
        });
    }


    $scope.monthly_report_button = function(url)
    {   
        /*$scope.m_monthly_report = [];
        $scope.m_total_sc_discounts=0;
        $scope.m_other_discounts=0;
        $scope.m_total_pwd_discounts=0;
        $scope.m_total_nontax_sales=0;
        $scope.m_total_taxvat=0;
        $scope.m_total_cash_sales=0;
        $scope.m_total_gross_sales=0;
        $scope.m_total_net_sales=0;*/

        $http.post(url).success(function(result){
            $scope.monthly_report=result.daily;
            $scope.monthly = result.monthly;

            /*if(result.length != 0)
            {
                for(var i = 0; i < result.length; i++)
                {
                    $scope.m_total_gross_sales += parseFloat(result[i].total_gross_sales);
                    $scope.m_total_nontax_sales += parseFloat(result[i].total_nontax_sales);
                    $scope.m_total_sc_discounts += parseFloat(result[i].total_sc_discounts);
                    $scope.m_total_pwd_discounts += parseFloat(result[i].total_pwd_discounts);
                    $scope.m_other_discounts += parseFloat(result[i].other_discounts);
                    $scope.m_total_taxvat += parseFloat(result[i].total_taxvat);
                    $scope.m_total_net_sales += parseFloat(result[i].total_net_sales);
                    $scope.m_total_cash_sales += parseFloat(result[i].total_cash_sales);
                }
            }*/            

            console.log(result);
        });
    }

    $scope.leasing_data_button = function(url)
    {   
        $scope.leasing_data = [];
        $http.post(url).success(function(result){
            $scope.leasing_data=result;
            console.log(result);
        });
    }



    $scope.delupload_status_button = function(url)
    {   
        $scope.upload_status_list = [];
        $http.post(url).success(function(result){
            $scope.upload_status_list=result;
            console.log(result);
        });
    }

    $scope.details = function(url)
    {
        $scope.dataList = [];
        $http.post(url).success(function(result){
            $scope.dataList=result;
            console.log(result);
        });
    }

    $scope.update_hourly_sales = function (url, id)
    {
        $scope.update_hourly = [];
        $http.post(url + id).success(function(result){
            $scope.update_hourly=result;

        });

    }
   

    $scope.delete = function (url)
    {   
        document.getElementById('anchor_delete').href = url;
    }

    $scope.approve = function (url)
    {   
        document.getElementById('anchor_approve').href = url;
    }

    $scope.disapprove = function (url)
    {   
        document.getElementById('anchor_disapprove').href = url;
    }

    //  $scope.truncate = function (url)
    // {
    //     document.getElementById('truncate').href = url;
    // }

    $scope.copy = function (url)
    {
        document.getElementById('copy').href = url;
    }

    $scope.confirm = function(url)
    {
        //alert(url);
        document.getElementById('anchor_confirm').href = url;    
    }

    $scope.block = function(url)
    {
        document.getElementById('anchor_block').href = url;    
    }

    $scope.deleteDataAjax = function(url, list = '', data = {})
    {       

        console.log("clicked");
        pop.confirm({
            message : 'Do you realy want to delete this data?',
            success : {
                text : `<i class="fa fa-trash"></i> Delete`,
                class : `btn-danger`
            }
        }).then(function(result){
            if(result == true){

                $http({
                    method: 'POST',
                    url: url,
                    data: $.param(data),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function(result){
                    display(result.type, result.msg, false);
                    console.log(result);

                    if(result.type == 'success'){
                        if(list != ''){
                        
                            list = eval(`$scope.${list}`);
                            console.log(list);
                        
                            var index = list.indexOf(data);
                            console.log(list[index]);
                            list.splice(index, 1);
                        }
                        
                    }  
                });
            }
        });
    }

    $scope.isEmpty = (obj) => {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }

        return true;
    }
});

app.controller('tablecontroller', function($scope, $http, $timeout, $rootScope)
{
    $rootScope.$on("CallTablelistMethod", function(event, data){
       $scope.loadList(data);
    });

    
    $scope.graphList=[];
    $scope.showGraph = function(url)
    {
        $http.post(url).success(function(result){
            $scope.showGraph=result;
            console.log(result);
        });
    }

    //Pagination

    $scope.itemsPerPage = 15;
    $scope.currentPage = 0;

    $scope.range = function() 
    {
        var rangeSize = $scope.pageCount() + 1;
        var ret = [];
        var start;

        start = $scope.currentPage;
        if ( start > $scope.pageCount()-rangeSize ) 
        {
            start = $scope.pageCount()-rangeSize+1;
        }

        for (var i=start; i<start+rangeSize; i++) 
        {
            ret.push(i);
        }
        return ret;
    }


    $scope.pageCount = function() 
    {
        return Math.ceil($scope.dataList.length/$scope.itemsPerPage)-1;
    }


    $scope.prevPage = function() 
    {
        if ($scope.currentPage > 0) 
        {
            $scope.currentPage--;
        }
    }

    $scope.prevPageDisabled = function() {
        return $scope.currentPage === 0 ? "disabled" : "";
    }

    
    $scope.nextPage = function() 
    {
        if ($scope.currentPage < $scope.pageCount()) 
        {
            $scope.currentPage++;
        }
    }

    $scope.nextPageDisabled = function() 
    {
        return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
    };

    $scope.setPage = function(n) 
    {
        $scope.currentPage = n;
    };



    $scope.dataList;
    $scope.listB = [];
    

    $scope.moveToListA = function(item)
    {
        $scope.dataList.push(item);
        $scope.listB.splice($scope.listB.indexOf(item), 1);   
    };

    $scope.moveToListB = function(item) 
    {
        $scope.listB.push(item);
        $scope.dataList.splice($scope.dataList.indexOf(item), 1);
    };

    $scope.total_inhourly_sales = 1;

    //Pagination

    // Pagination Data History

    


    $scope.pageCount1 = function() 
    {
        return Math.ceil($scope.hourlyHistory.length/$scope.itemsPerPage)-1;
    }

    $scope.firstPage1 = function()
    {
        $scope.currentPage = 0;

    }
    $scope.lastPage1 = function()
    {
        $scope.currentPage = Math.ceil($scope.hourlyHistory.length/$scope.itemsPerPage)-1;
    }
    $scope.range1 = function() 
    {
        if(Math.ceil($scope.hourlyHistory.length/$scope.itemsPerPage)-1 > $scope.hourlyHistory.length)
        {
            var rangeSize = $scope.pageCount1() + 1
        }else{
            var rangeSize = 10;
        }
        var ret = [];
        var start;

        start = $scope.currentPage;
        if ( start > $scope.pageCount1()-rangeSize ) 
        {
            start = $scope.pageCount1()-rangeSize+1;
        }

        for (var i=start; i<start+rangeSize; i++) 
        {
            ret.push(i);
        }
        return ret;
    }


    $scope.prevPage1 = function() 
    {
        if ($scope.currentPage > 0) 
        {
            $scope.currentPage--;
        }
    }

    $scope.prevPageDisabled1 = function() {
        return $scope.currentPage === 0 ? "disabled" : "";
    }

    
    $scope.nextPage1 = function() 
    {
        if ($scope.currentPage < $scope.pageCount1()) 
        {
            $scope.currentPage++;
        }
    }

    $scope.nextPageDisabled1 = function() 
    {
        return $scope.currentPage === $scope.pageCount1() ? "disabled" : "";
    };

    $scope.setPage1 = function(n) 
    {
        $scope.currentPage = n;
    };



    $scope.hourlyHistory;
    $scope.listB = [];
    

    $scope.moveToListA1 = function(item)
    {
        $scope.hourlyHistory.push(item);
        $scope.listB.splice($scope.listB.indexOf(item), 1);   
    };

    $scope.moveToListB1 = function(item) 
    {
        $scope.listB.push(item);
        $scope.hourlyHistory.splice($scope.hourlyHistory.indexOf(item), 1);
    };

    // Pagination Data History

    //Pagination Data History Daily

    $scope.pageCount2 = function() 
    {
        return Math.ceil($scope.dailyHistory.length/$scope.itemsPerPage)-1;
    }

    $scope.firstPage2 = function()
    {
        $scope.currentPage = 0;

    }
    $scope.lastPage2 = function()
    {
        $scope.currentPage = Math.ceil($scope.dailyHistory.length/$scope.itemsPerPage)-1;
    }

     $scope.range2 = function() 
    {
        if(Math.ceil($scope.dailyHistory.length/$scope.itemsPerPage)-1 > $scope.dailyHistory.length)
        {
            var rangeSize = 10;
        }else{
            var rangeSize = $scope.pageCount2() + 1;
        }

        var ret = [];
        var start;

        start = $scope.currentPage;
        if ( start > $scope.pageCount2()-rangeSize ) 
        {
            start = $scope.pageCount2()-rangeSize+1;
        }

        for (var i=start; i<start+rangeSize; i++) 
        {
            ret.push(i);
        }
        return ret;
    }

    $scope.prevPage2 = function() 
    {
        if ($scope.currentPage > 0) 
        {
            $scope.currentPage--;
        }
    }

    $scope.prevPageDisabled2 = function() {
        return $scope.currentPage === 0 ? "disabled" : "";
    }

    
    $scope.nextPage2 = function() 
    {
        if ($scope.currentPage < $scope.pageCount2()) 
        {
            $scope.currentPage++;
        }
    }

    $scope.nextPageDisabled2 = function() 
    {
        return $scope.currentPage === $scope.pageCount2() ? "disabled" : "";
    };

    $scope.setPage2 = function(n) 
    {
        $scope.currentPage = n;
    };



    $scope.dailyHistory;
    $scope.listB = [];
    

    $scope.moveToListA2 = function(item)
    {
        $scope.dailyHistory.push(item);
        $scope.listB.splice($scope.listB.indexOf(item), 1);   
    };

    $scope.moveToListB2 = function(item) 
    {
        $scope.listB.push(item);
        $scope.dailyHistory.splice($scope.dailyHistory.indexOf(item), 1);
    };

     //Pagination Data History Daily

    $scope.pageCount3 = function() 
    {
        return Math.ceil($scope.input_list.length/$scope.itemsPerPage)-1;
    }

    $scope.firstPage3 = function()
    {
        $scope.currentPage = 0;

    }
    $scope.lastPage3 = function()
    {
        $scope.currentPage = Math.ceil($scope.input_list.length/$scope.itemsPerPage)-1;
    }


     $scope.range3 = function() 
    {
        if(Math.ceil($scope.input_list.length/$scope.itemsPerPage)-1 > 150)
        {
            var rangeSize = 10;
        }else{
            var rangeSize = $scope.pageCount3() + 1;
        }

        var ret = [];
        var start;

        start = $scope.currentPage;
        if ( start > $scope.pageCount3()-rangeSize ) 
        {
            start = $scope.pageCount3()-rangeSize+1;
        }

        for (var i=start; i<start+rangeSize; i++) 
        {
            ret.push(i);
        }
        return ret;   
    }

    $scope.prevPage3 = function() 
    {
        if ($scope.currentPage > 0) 
        {
            $scope.currentPage--;
        }
    }

    $scope.prevPageDisabled3 = function() {
        return $scope.currentPage === 0 ? "disabled" : "";
    }

    
    $scope.nextPage3 = function() 
    {
        if ($scope.currentPage < $scope.pageCount3()) 
        {
            $scope.currentPage++;
        }
    }

    $scope.nextPageDisabled3 = function() 
    {
        return $scope.currentPage === $scope.pageCount3() ? "disabled" : "";
    };

    $scope.setPage3 = function(n) 
    {
        $scope.currentPage = n;
    };



    $scope.input_list;
    $scope.listB = [];
    

    $scope.moveToListA3 = function(item)
    {
        $scope.input_list.push(item);
        $scope.listB.splice($scope.listB.indexOf(item), 1);   
    };

    $scope.moveToListB3 = function(item) 
    {
        $scope.listB.push(item);
        $scope.input_list.splice($scope.input_list.indexOf(item), 1);
    };

    /*$scope.deleteDataAjax = function(url, list = '', data = {})
    {       

        console.log("clicked");
        pop.confirm({
            message : 'Do you realy want to delete this data?',
            success : {
                text : `<i class="fa fa-trash"></i> Delete`,
                class : `btn-danger`
            }
        }).then(function(result){
            if(result == true){
                $http.post(url).success(function(result){

                    display(result.type, result.msg, false);

                    if(result.type == 'success'){
                        if(list != ''){
                        
                            list = eval(`$scope.${list}`);
                            console.log(list);
                        
                            var index = list.indexOf(data);
                            list.splice(index, 1);
                        }
                        
                    }
                        
                    
                });
            }
        });
    }*/

 });












app.filter('tableOffset', function() {
    return function(list, page, ipp) {
        if (!list || !list.length) { return; }

        var start =  Math.ceil(page * ipp);
        var end = start + ipp;

        //console.log('Table Offset :', start, end);
        start = +start; //parse to int
        return list.slice(start, end);
    }
});

app.filter('sortBy', function() {
    return function(list, field, reverse = false) {

        if(list && field ){
            list.sort(function(a,b) {
                var val1  = isNaN(a[field]) ? a[field] : Number(a[field]);
                var val2  = isNaN(b[field]) ? b[field] : Number(b[field]);

                if (val1  < val2 ){
                  return !reverse ? -1 : 1;
                }
                if (val1  > val2 ){
                  return !reverse  ? 1 : -1;
                }

                return 0;
            });
        }

        return list;
    }
});



app.controller('mytablecontroller', function($scope, $http, $timeout, $rootScope)
{
    $scope.page = 0;
    $scope.total_page = 0;
    $scope.ppr = 10;

    $scope.ipp = 10;
    $scope.offset = 0;
    $scope.total_result = 0;
    $scope.leaps = false;

    $scope.field = '';
    $scope.reverse = false;
    
    $scope.sort = (column)=>{
        $scope.field = column;
        $scope.reverse = !$scope.reverse;
    }

    $scope.disable = (btn = '') => {

        switch(btn){
            case 'first'    :
            case 'prev'     :
                return $scope.page == 0;
                break;

            case 'last'     :
            case 'next'     : 
                return $scope.page == ($scope.total_page -1);
                break;
        }
        
    }

    $scope.tableList = [];

    $scope.paginate = (list) => {
        if(!list)
            list = [];

        if(isEqual($scope.tableList, list) === false){
            console.log("NOT matched!");
            $scope.page = 0;
            $scope.tableList = list;
        }

        $scope.total_page = Math.ceil(list.length/$scope.ipp);
        $scope.total_result = list.length;
        return list.length;
    }

    $scope.range = ()=> {
        var from = Math.floor($scope.page / $scope.ppr) * $scope.ppr;
        var to  =  (from + $scope.ppr) < $scope.total_page ? (from + $scope.ppr) : $scope.total_page;

        var range = [];
        for(c = from; c < to; c ++){
            range.push(c);
        }

        return range;
    }

    $scope.nextPage = ()=>{
        if($scope.page < $scope.total_page -1){

            var page = Math.floor($scope.page / $scope.ppr) * $scope.ppr + $scope.ppr;
            
            if($scope.leaps && page  < $scope.total_page){
                $scope.page = page;
            } else{
                $scope.page = $scope.page + 1;
            }
           
        }
    }

    $scope.prevPage = ()=>{
        if($scope.page != 0){
            var page = Math.floor($scope.page / $scope.ppr) * $scope.ppr - $scope.ppr;
            //console.log(page);
            if($scope.leaps && page > 0){
                $scope.page = page;
            } else{
                $scope.page = $scope.page - 1;
            }
            
        }
    }

    $scope.firstPage = ()=>{
        $scope.page = 0;
    }

    $scope.lastPage = () => {
        $scope.page = $scope.total_page - 1;
    }

    $scope.setPage = (n)=> {
        $scope.page = n;
    }

});




    
app.controller('chartController', function ($scope, $http, $filter,$interval)

{   

    $scope.startTimeValue = 1430990693334;
    $scope.theme = 'dark';

    
    $scope.clock = "Loading Date and Time..."; // initialise the time variable
    $scope.tickInterval = 1000 //ms
    $scope.tick = function(url) {

        $interval(function(){
            $http.post(url).success(function(result){
                $scope.clock = result.current_dateTime; // get the current time
            });
        }.bind(this), 1000);    
    }
      

    Chart.defaults.global.scaleLabel = function(label){
        return '₱ ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    };

    Chart.defaults.global.tooltipTemplate = function(label){
        return label.label + ': ₱ ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    Chart.defaults.global.multiTooltipTemplate = function (label) {
        return label.datasetLabel + ': ₱ ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }; 


    $scope.chart_view = function(url)
    {   

        $http.post(url).success(function(result){
            $scope.labels = [];
            $scope.series = ['Total Net Sales', 'Total Gross Sales'];
            $scope.data = [];
            $scope.colours = [];

            $scope.onClick = function (points, evt) {
                console.log(points, evt);
            };

            var trade_name = [];
            var total_net_sales = [];
            var total_gross_sales = [];

            for (var i = 0; i < result.length; i++) 
            {    
                $scope.labels.push(result[i].trade_name);
                total_net_sales.push(result[i].total_net_sales);
                total_gross_sales.push(result[i].total_gross_sales);

                if(result[i].date_end.length > 0)
                    $scope.date = result[i].date_end;

            }

            if(result.length != 0)
                $scope.data = [total_net_sales, total_gross_sales];
                        
            console.log(result,  $scope.data, $scope.labels);

        });
    }


    $scope.home_view_chart = function(url)
    {
        $scope.showGraph = !$scope.showGraph;

        $http.post(url).success(function(result){
            $scope.labels = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $scope.data = [];
            $scope.series = ['Total Gross Sales','Total Netsales Amount']
            $scope.colours = [];
            $scope.date_end=[];

            var trade_name = [];
            var total_gross_sales = [];
            var total_netsales_amount = [];
            var date_end = [];

            for (var i = 0; i < result.length; i++) 
            {    

                total_gross_sales.push(result[i].total_gross_sales);
                total_netsales_amount.push(result[i].total_netsales_amount);
                $scope.date_end.push(result[i].date_end);

            }   

                $scope.data = [
                total_gross_sales,
                total_netsales_amount
      
                            ];

            var qwe = $scope.date_end;        
            // var asd = qwe.split('-');
            // var zxc = asd[1];

            console.log(result);
            console.log(qwe);
            console.log(total_gross_sales);
        });
    }

    $scope.chartLatest12MonthSale = function(url)
    {
        $scope.showGraph = !$scope.showGraph;

        $http.post(url).success(function(result){
            $scope.labels = result.date;

            $scope.data = [result.total_gross_sales, result.total_netsales_amount];
            $scope.series = ['Total Gross Sales','Total Netsales Amount']
            $scope.colours = [];

            console.log(result);
        });
    }

});



app.controller('testController',function($scope,$http){
    $scope.numberToAdd = '';
    $scope.numbersAdded = [];
    $scope.used = null;
    $scope.count = 0;
    $scope.progress = 0;
    $scope.fastMode = true;

    $scope.calculate = ()=>{
        $scope.used = null;
        $scope.$applyAsync();

        var target   = $scope.fastMode ? Math.abs(parseFloat($scope.search)) : parseFloat($scope.search);

        const numbers = $scope.numbersAdded.sort((a, b)=>{
            return b-a;
        }) 

        console.log(numbers);
        //sum_up_recursive(numbers, target);
    }  

    $scope.sum = ()=>{
        let sum = 0;
        if($scope.used)
            $scope.used.forEach(x => sum+=x);

        return Number.parseFloat(sum).toFixed(2);
    }

    $scope.max_variance_allowed = 0;

    $scope.gl_accounts = [];

    $scope.getInitialData= ()=>{
        $http.post($base_url + 'tracing_controller/get_init').success((result)=>{
            $scope.gl_accounts = result.gl_accounts;
            $scope.stores = result.stores;
        });
    }

    $scope.getGLAccounts= (doc_type = 'invoice')=>{
        $http.post($base_url + 'tracing_controller/get_gl_accounts/'+doc_type).success((result)=>{
            $scope.gl_accounts = result;
        });
    }

    $scope.getPaymentsByDocNos= (data)=>{
        $("#loading-modal").modal("show");
        $.post({
            url : $base_url + 'tracing_controller/get_payment_by_doc_nos',
            data,
            success : (result)=>{
                $scope.entries = result;
                $scope.$apply();
                $("#loading-modal").modal("hide");
            }
        })
        
    }

    $scope.gl_data = null;
    $scope.getGlData = (e, url = 'tracing_controller/get_gl_data')=>{

        $("#loading-modal").modal("show");
        $scope.used = null;
        $scope.gl_matches = null;

        e.preventDefault();

        let data = $(e.target).serializeObject();

        $.post({
            url : $base_url + url,
            data : data,
            success : (result)=>{
                setTimeout(()=>{
                    $("#loading-modal").modal("hide");
                }, 300)

                if(data.csv){
                    window.open($base_url + 'reports/'+result);
                }else{
                    $scope.gl_data = result;
                    $scope.grouped_glData = groupBy(mergeArrayValues(result), 'gl_account');

                    $scope.$apply();
                } 
            }
        })
    }


    $scope.toKebabCase = toKebabCase;

    $scope.groupArrayBy = (arr, col)=>{
        return groupBy(arr, col);
    }

    $scope.mergeArrayValues = (arr)=>{
        return mergeArrayValues(arr);
    }

    $scope.groupArrayByDate = groupArrayByDate;

    $scope.getColPosTotal = (data, col, precision = 2)=>{
        data = data.map((dt)=>{
            return dt[col];
        })

        var total = 0;

        data.forEach((val)=>{
            var amount =  parseFloat(val) || 0;
            total += (amount > 0 ? amount : 0);
        })

        return parseFloat(total.toFixed(precision));
    }

    $scope.getColNegTotal = (data, col, precision = 2)=>{
        data = data.map((dt)=>{
            return dt[col];
        })

        var total = 0;

        data.forEach((val)=>{
            var amount =  parseFloat(val) || 0;
            total += (amount < 0 ? amount : 0);
        })

        return parseFloat(total.toFixed(precision));
    }

    $scope.getColTotal = (data, col, precision = 2)=>{
        data = data.map((dt)=>{
            return dt[col];
        })

        var total = 0;

        data.forEach((val)=>{
            total += parseFloat(val) || 0;
        })

        return parseFloat(total.toFixed(precision));
    }

    $scope.getRowsTotal = (rows, col) =>{
        var total = 0;

        if(typeof rows == 'object'){
            rows = Object.values(rows);
        }

        rows.forEach((row)=>{
            total += $scope.getColTotal(row, col);
        })

        return total;
    }

    $scope.total_credit = ()=>{
        let total = 0;

        if(!$scope.gl_data) return 0;

        $scope.gl_data.forEach((gl)=>{
            total += parseFloat(gl.credit);
        })

        return total;
    }

    $scope.total_debit = ()=>{
        let total = 0;

        if(!$scope.gl_data) return 0;

        $scope.gl_data.forEach((gl)=>{
            total += parseFloat(gl.debit);
        })

        return total;
    }

    $scope.lookIn = null;
    $scope.lookup = ()=>{

        $scope.numbersAdded = $scope.gl_data.map((gl)=>{
            if($scope.lookIn == "credit")
                return $scope.fastMode ? Math.abs(parseFloat(gl.credit)) : parseFloat(gl.credit);

            if($scope.lookIn == "debit")
                return $scope.fastMode ? Math.abs(parseFloat(gl.debit)) : parseFloat(gl.debit);
                
        }).filter(v=> v!= 0);

        $scope.used = null;

        $scope.processOffline();
    }

    $scope.processOnline = ()=>{

        var target   = $scope.fastMode ? Math.abs(parseFloat($scope.search)) : parseFloat($scope.search);

        const numbers = $scope.numbersAdded.sort((a, b)=>{
            return b-a;
        }) 

        var  max        = $scope.max_variance_allowed;
        var fastMode    = $scope.fastMode;


        var data = {
            numbers,
            target,
            max,
            fastMode,
        }

       

        $.post({
            url : $base_url + 'tracing_controller/sum_up',
            data,
            beforeSend : ()=>{
                $("#loading-modal").modal("show");
            },
            success : (res)=>{

                if(res.type != "success"){
                    alert(res.msg);
                    return;
                }

                var source = new EventSource($base_url + "tracing_controller/monitor/" + res.id);
    
                source.addEventListener('progress', (e)=>{
                    result = JSON.parse(e.data);
                   
                    $scope.progress = result.progress;
                    $scope.$apply();

                    if(!result.done) return;

                    $scope.progress = result.progress;

                    $scope.used =  result.data;

                    $scope.gl_matches = get_gl_matches();

                    $scope.$apply();

                    source.close();

                    $("#loading-modal").modal("hide");     
                }, false);

                source.addEventListener('error', function(e) {
                   alert('Error occurred');
                   source.close();
                });

               
                
            }
        })
    }

    $scope.processOffline = function(){
        let count = 0;



        let sum_up_recursive = (numbers, target, partial = [])=>{
            count ++;
                // $scope.progress = Math.round(count / Math.pow(2, $scope.numbersAdded.length) * 100);
                // setTimeout(function() {
                //     console.log("progress", $scope.progress);
                // }, 20);
      
            //console.log(partial, numbers);

            let s= 0;

            partial.forEach(x=>{s += x});

            s       = Number.parseFloat(s.toFixed(2));
            target  = Number.parseFloat(target.toFixed(2));


            if(Math.abs(s - target)  <= $scope.max_variance_allowed){
                console.log("FOUND SOME MATCHES");
                $scope.used = partial;

                // setTimeout(function() {
                //     $scope.progress =  100;
                //     console.log($scope.progress);
                // }, 20);
                return;
            }

            //console.log(parseFloat(s)>parseFloat(target));

            var target_max = parseFloat((target + $scope.max_variance_allowed).toFixed(2));

            if(s > target_max && $scope.fastMode) {
                console.log("entered 1!");
                return;
            }


            numbers.forEach(x=>{s += x});

            var sum_max = parseFloat((s + $scope.max_variance_allowed).toFixed(2));

            if(target > sum_max){
                console.log("entered 2!", "target:"+ target, "sum + max : " + parseFloat((s + $scope.max_variance_allowed).toFixed(2)));

                return;
            }

            for (let i = 0; i < numbers.length; i++)
            {
                if($scope.used.length != 0) return;

                let remaining = [];

                for (let j = i + 1; j < numbers.length; j++) {
                    remaining.push(numbers[j]);
                }

                let partial_rec = partial.slice(0);
                partial_rec.push(numbers[i]);            
               
                sum_up_recursive(remaining, target, partial_rec); 
            }
       
        }

        var target   = $scope.fastMode ? Math.abs(parseFloat($scope.search)) : parseFloat($scope.search);

        const numbers = $scope.numbersAdded.sort((a, b)=>{
            return b-a;
        }) 
        $scope.used = [];

        $scope.max_variance_allowed  = parseFloat($scope.max_variance_allowed);

        $("#loading-modal").modal("show");
        setTimeout(() => {
            sum_up_recursive(numbers, target);

            $scope.gl_matches = get_gl_matches();
            $scope.$applyAsync();

            //$scope.progress = 100;

            setTimeout(() => {
                 $("#loading-modal").modal("hide");
            }, 100);
        }, 300);
        
    }

   

    $scope.gl_matches = null;

    let get_gl_matches = ()=>{
        if(!$scope.used) return null;

        if($scope.used.length == 0) return [];

        var gl_data = $scope.gl_data.slice(0);

        var matches = [];

        $scope.used.forEach((val)=>{
            let found = false;
            gl_data.some((gl, i)=>{

                let cr_match = $scope.fastMode ? (Math.abs(parseFloat(gl.credit)) == val) : (parseFloat(gl.credit) == val);
                let db_match = $scope.fastMode ? (Math.abs(parseFloat(gl.debit)) == val) : (parseFloat(gl.debit) == val);

                if(($scope.lookIn == "credit" && cr_match) || ($scope.lookIn == "debit" && db_match)) {
                    matches.push(gl);
                    gl_data.splice(i, 1);
                    found = true;
                }

                return found;
            })
        })

        return matches;
    }

    $scope.total_match_credit = ()=>{
        let total = 0;

        if(!$scope.gl_matches) return 0;

        $scope.gl_matches.forEach((gl)=>{
            total += parseFloat(gl.credit);
        })

        return total;
    }

    $scope.total_match_debit = ()=>{
        let total = 0;

        if(!$scope.gl_matches) return 0;

        $scope.gl_matches.forEach((gl)=>{
            total += parseFloat(gl.debit);
        })

        return total;
    }

    $scope.copyToClipRow = (data)=>{

        data = `${data.doc_no} - ${data.trade_name} - (${data.debit ? data.debit : data.credit}) - ${data.document_type}`;

        // Create a dummy input to copy the string array inside it
        var dummy = document.createElement("textarea");

        // Add it to the document
        document.body.appendChild(dummy);

        // Set its ID
        dummy.value= data;

        // Select it
        dummy.select();

        // Copy its contents
        document.execCommand("copy");

        // Remove it as its not needed anymore
        document.body.removeChild(dummy);

        $('#copiedToClipText').fadeIn(1000, ()=>{
            setTimeout(()=>{
                $('#copiedToClipText').fadeOut(1000);
            }, 1000);
        })
    }

    $scope.copyToClip = ()=>{


        
        let data = "";

        $scope.gl_matches.forEach((gl)=>{
            //data+= `${gl.doc_no} - ${gl.trade_name} (${$scope.lookIn == "credit" ? gl.credit : gl.debit}) (${gl.doc_type}) \n\n`; 
            data+= `${gl.doc_no} : ${$scope.lookIn == "credit" ? (gl.credit > 0 ? gl.credit : '(' + gl.credit*-1 + ')' ) : gl.debit} \n`

        })

        // Create a dummy input to copy the string array inside it
        var dummy = document.createElement("textarea");

        // Add it to the document
        document.body.appendChild(dummy);

        // Set its ID
        dummy.value= data;

        // Select it
        dummy.select();

        // Copy its contents
        document.execCommand("copy");

        // Remove it as its not needed anymore
        document.body.removeChild(dummy);

        $('#copiedToClipText').fadeIn(1000, ()=>{
            setTimeout(()=>{
                $('#copiedToClipText').fadeOut(1000);
            }, 1000);
        })
    }

    $scope.removeFromArray = (arr, data)=>{
        if(typeof arr != 'object') return;

        var index = arr.indexOf(data);

        arr.splice(index, 1);
    }

});