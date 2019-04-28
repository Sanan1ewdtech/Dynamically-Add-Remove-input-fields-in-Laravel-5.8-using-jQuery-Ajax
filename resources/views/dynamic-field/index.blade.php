<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <br/>
                    <h3 align="center">Dynamically Add / Remove input fields in Laravel 5.8 using Ajax jQuery</h3>
                <br/>
                <form action="" method="post" id="dynamic_form">
                    @csrf
                    <span id="result"></span>
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <td colspan="2"></td>
                            <td>
                                <input type="submit" class="btn btn-success" name="save" id="save" value="save">
                            </td>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){

            var count = 1;
            
            dynamicField(count);

            function dynamicField(number){
                html = '<tr>';
                html += '<td><input type="text" name="first_name[]" class="form-control" placeholder="First Name"></td>';
                html += '<td><input type="text" name="country[]" class="form-control" placeholder="Country Name"></td>';

                if(number > 1){
                    html += '<td><button type="button" name="remove"  class="btn btn-danger remove">Remove</button></td>';
                    html += '</tr>';
                    $('tbody').append(html);
                }else{
                    html += '<td><button type="button" name="add" id="add" class="btn btn-info add">Add</button></td>';
                    $('tbody').html(html);
                }

            }

            $(document).on('click','#add',function(){
                count++;
                dynamicField(count);
            });

            $(document).on('click','.remove',function(){
                count--;
                $(this).closest("tr").remove();
            });

            $('#dynamic_form').on('submit',function(event){
                event.preventDefault();
                $.ajax({
                    method : 'post',
                    url : '{{ route("dynamict_field.add") }}', 
                    data : $(this).serialize(),
                    dataType : 'json',
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(data){
                        if(data.error)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<p>'+data.error[count]+'</p>';
                            }
                            $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                        }
                        else
                        {
                            dynamic_field(1);
                            $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                        }
                        $('#save').attr('disabled', false);
                    }
                });
            });


        });
    </script>
  </body>
</html>

{{-- $('#dynamic_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
        url:'{{ route("dynamic-field.insert") }}',
        method:'post',
        data:$(this).serialize(),
        dataType:'json',
        beforeSend:function(){
            $('#save').attr('disabled','disabled');
        },
        success:function(data)
        {
            if(data.error)
            {
                var error_html = '';
                for(var count = 0; count < data.error.length; count++)
                {
                    error_html += '<p>'+data.error[count]+'</p>';
                }
                $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
            }
            else
            {
                dynamic_field(1);
                $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
            }
            $('#save').attr('disabled', false);
        }
    })
}); --}}
