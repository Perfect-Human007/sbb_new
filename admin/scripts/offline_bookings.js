

let offbookings_s_form = document.getElementById('offbookings_s_form');


offbookings_s_form.addEventListener('submit', function(e)
{
  e.preventDefault();
  add_booking();
})

function add_booking()
{

  let data = new FormData();
  data.append('name', offbookings_s_form.elements['name'].value);
  data.append('payment', offbookings_s_form.elements['payment'].value);
  data.append('proof', offbookings_s_form.elements['proof'].files[0]);
  data.append('offbookings_desc', offbookings_s_form.elements['offbookings_desc'].value);

  data.append('add_booking','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/offline_bookings.php",true);


  xhr.onload = function(){
    
    var myModal = document.getElementById('offbookings-s')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    
    if(this.responseText == 'inv_img'){
      alert('error','Only .jpg .png .webp formats are allowed!');
    }else if(this.responseText == 'inv_size'){
      alert('error','Size should be less then 5 MB');
    }else if(this.responseText == 'upd_failed'){
      alert('error','Image upload failed!');
    }else{
      alert('success','New Record Added');
      offbookings_s_form.reset();
      get_bookings();
    }

  }


  xhr.send(data);
} 

function get_bookings(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/offline_bookings.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  
  xhr.onload = function(){

  document.getElementById('offbookings-data').innerHTML = this.responseText;

  }
  xhr.send('get_bookings');
}

function rem_booking(val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/offline_bookings.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  
  xhr.onload = function(){
  if(this.responseText == 1){
    alert('success', 'Record removed');
    get_bookings();
  }
 else{
    alert('error', 'Server down!');
  }

  }
  xhr.send('rem_booking='+val);
}


window.onload = function(){
  get_bookings();
}



