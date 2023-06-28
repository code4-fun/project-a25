$('#price_button').on('click', function(e){
  e.preventDefault()
  const product = $('#product').val()
  const days = $('#customRange1').val()
  let counter = 0
  let checked_services = ''
  const check_boxes = $("input[data-check]")
    .filter(function(){
      return $(this).is(":checked")
    }).each(function(){
      if(counter === 0){
        checked_services = $(this).val()
      } else {
        checked_services = checked_services + '<<>>' + $(this).val()
      }
      counter++;
    })

  $.ajax({
    url: "/backend/functions.php",
    type: 'POST',
    dataType:'json',
    data: {
      function: 'calculate_price',
      product: product,
      days: days,
      checked_services: checked_services
    },
  }).done((data) => {
    $('.result_price').html(data)
  })
})
