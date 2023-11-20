
let general_data;

let general_s_form = document.getElementById('general_s_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');

let team_s_form = document.getElementById('team_s_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

function get_general(){

  let site_title = document.getElementById('site_title');
  let site_about = document.getElementById('site_about');

 

  let shutdown_toggle = document.getElementById('shutdown-toggle');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  
  xhr.onload = function(){
     general_data =  JSON.parse(this.responseText);
      console.log(general_data);
    
      site_title.innerText = general_data.site_title;
      site_about.innerText = general_data.site_about; 
    

      site_title_inp.value = general_data.site_title;
      site_about_inp.value = general_data.site_about;
    

      if(general_data.shutdown == 0){
         shutdown_toggle.checked = false;
         shutdown_toggle.value = 0;
      }else{
        shutdown_toggle.checked = true;
         shutdown_toggle.value = 1;
      }

  }
  xhr.send('get_general');
}



general_s_form.addEventListener('submit', function(e){
  e.preventDefault();
  upd_general(site_title_inp.value,site_about_inp.value);
})



function upd_general(site_title_val,site_about_val){
  
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  
  xhr.onload = function(){

    var myModal = document.getElementById('general-s')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    console.log(this.responseText)
    if(this.responseText == 1 ){
      alert('success', 'Changes saved!')
      console.log('data updated');
      get_general();
    }else{
      alert('error', 'No Changes made!')
      console.log('data updating failed');
    }
  }
  xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&upd_general');
}


function upd_shutdown(val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  
  xhr.onload = function()
  {
    if(this.responseText == 1 && general_data.shutdown==0 ){
      alert('success', 'Site has been Shutdown!');
    }else{
      alert('success', 'Site is Online! Welcome Back');
    }
    get_general();
  }

  xhr.send('upd_shutdown='+val);
}


team_s_form.addEventListener('submit', function(e){
  e.preventDefault();
  add_member();
})

function add_member(){

  let data = new FormData();
  data.append('name', member_name_inp.value);
  data.append('picture', member_picture_inp.files[0]);
  data.append('add_member','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);

  
  xhr.onload = function(){
     
    var myModal = document.getElementById('team-s')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    
    if(this.responseText == 'inv_img'){
      alert('error','Only .jpg and .png formats are allowed!');
    }else if(this.responseText == 'inv_size'){
      alert('error','Size should be less then 5 MB');
    }else if(this.responseText == 'upd_failed'){
      alert('error','Image upload failed!');
    }else{
      alert('success','New Member Added');
      member_name_inp.value ='';
      member_picture_inp.value='';
      get_members();
    }

  }


  xhr.send(data);
} 


function get_members(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  
  xhr.onload = function(){
 
   document.getElementById('team-data').innerHTML = this.responseText;

  }
  xhr.send('get_members');
}

function rem_member(val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  
  xhr.onload = function(){
   if(this.responseText == 1){
    alert('success', 'Member has been removed');
    get_members();
   }else{
    alert('error', 'Server down!');
   }

  }
  xhr.send('rem_member='+val);
}







window.onload = function(){
  get_general();
  get_members();
}
