<script>
    // get users 
    function afbGetUsers(role_id) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: '/api/get/users?role_id=' + role_id,
            headers: {
                'Authorization': 'Bearer {{ $token }}'
            },
            success: function(data) {
                resolve(data); // Resolve the Promise with the data
            },
            error: function(error) {
                reject(error); // Reject the Promise with the error, if any
            }
        });
    });
}



function deleteResource(id){

    let $confirm= confirm("Are you sure you want to delete?")

    if($confirm){
        $("#"+id).submit()
    }
    
}


</script>
