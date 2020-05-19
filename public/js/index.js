$(document).ready(function(){
    var l = $('#list').children()
    var arr = Array.from(l)

    arr.forEach(el => {
    $(el).on('click', (e) => {
     e.preventDefault();
     var url = e.target.href
     var data = {'id' : e.target.id}
     $.ajax({
         url: url,
         data: data
     })
     .done(function(res){
         data
        // $('#container').hide();
        res.forEach(el => {
            console.log(el)
            $('#container').append('<p>'+el.name+'</p>'+'<img src='+el.img+' style="width:20px">')
        })
        // $('#blockL').show()
     })
    })
})
})