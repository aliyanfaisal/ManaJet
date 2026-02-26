<script>
    console.log("close sidebar")
    $( window ).on( "load", function(){
       setTimeout(() => {
        $("#afb-sidebar .afb-hamburger:not('is-active')").click()
       }, 500);
    })
</script>