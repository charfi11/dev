$(document).ready(function(){
    var l = $('#list').children()
    l.each(function(){
    $($(this)).on('click', (ev) => {
     ev.preventDefault();
     $('#l').show()
     var url = ev.target.href
     var data = {'id' : ev.target.id}
     $.ajax({
         url: url,
         data: data
     })
     .done(function(res){
        data
        $('#l').css('visibility', 'visible')
        $('#l').empty()
        $('#l').append('<i class="fas fa-window-close" id="cl"></i>')
        $('#cl').on('click', (e) => {
            $('#l').hide();
        })
        res.forEach(e => {
            $('#l').append('<div class="card animate__animated animate__flipInX col s3">'+'<div class="bodycard">'+'<img class="cardimg" src='+e.img+'>'
            +'<p>'+e.name+'</p>'+'</div>'+'</div>')
        })
      })
    })
  })
})