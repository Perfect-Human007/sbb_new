

let add_package_form = document.getElementById('add_package_form');

add_package_form.addEventListener('submit', function(e){
e.preventDefault();
add_package();
})

function add_package()
{

  let data = new FormData();
  data.append('name', add_package_form.elements['name'].value);
  data.append('price', add_package_form.elements['price'].value);
  data.append('desc', add_package_form.elements['desc'].value);
  data.append('add_package','');

  let features = [];
  add_package_form.elements['features'].forEach(el =>{
    if(el.checked){
      console.log(el.value);
      features.push(el.value);
    }
  });

  let facilities = [];
  add_package_form.elements['facilities'].forEach(el =>{
    if(el.checked){
      console.log(el.value);
      facilities.push(el.value);
    }
  });
  
  data.append('features', JSON.stringify(features));
  data.append('facilities', JSON.stringify(facilities));


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);


  xhr.onload = function(){

    var myModal = document.getElementById('add-package')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1){
    alert('success','New package Added');
    add_package_form.reset();
    
    }else{
    alert('error','Server down!');
    }
    get_packages();
  }
  xhr.send(data);
} 

function get_packages()
{
 
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

    document.getElementById('package-data').innerHTML = this.responseText;


  }


  xhr.send('get_packages');
}

function toggle_status(id,val)
{
 
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

    if(this.responseText == 1){
    alert('success','status toggled');
    get_packages();

    }else{
    alert('error','Server down!');
    }



  }


  xhr.send('toggle_status='+id+'&value='+val);
}

let edit_package_form = document.getElementById('edit_package_form');
function edit_details(id)
{
  
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

  let data = JSON.parse(this.responseText);
  edit_package_form.elements['name'].value = data.packagedata.name;
  edit_package_form.elements['price'].value = data.packagedata.price;
  edit_package_form.elements['desc'].value = data.packagedata.description;
  edit_package_form.elements['packages_id'].value = data.packagedata.id;
  
  edit_package_form.elements['features'].forEach(el =>{
    if(data.features.includes(Number(el.value))){
     el.checked = true;
    }
  });

  edit_package_form.elements['facilities'].forEach(el =>{
    if(data.facilities.includes(Number(el.value))){
     el.checked = true;
    }
  });
  
  }


  xhr.send('get_package='+id);
}

edit_package_form.addEventListener('submit', function(e){
e.preventDefault();
submit_edit_package();
})

function submit_edit_package()
{

  let data = new FormData();
  data.append('name', edit_package_form.elements['name'].value);
  data.append('price', edit_package_form.elements['price'].value);
  data.append('desc', edit_package_form.elements['desc'].value);
  data.append('edit_package','');
  data.append('packages_id',edit_package_form.elements['packages_id'].value);

  let features = [];
  edit_package_form.elements['features'].forEach(el =>{
    if(el.checked){
      console.log(el.value);
      features.push(el.value);
    }
  });

  let facilities = [];
  edit_package_form.elements['facilities'].forEach(el =>{
    if(el.checked){
      console.log(el.value);
      facilities.push(el.value);
    }
  });
  
  data.append('features', JSON.stringify(features));
  data.append('facilities', JSON.stringify(facilities));


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);


  xhr.onload = function(){

    var myModal = document.getElementById('edit-package')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1){
    alert('success','Package/Room has been edited');
    edit_package_form.reset();
    get_packages();
    
    }else{
    alert('error','Server down!');
    }

  }


  xhr.send(data);
} 

let add_image_form = document.getElementById('add_image_form');
add_image_form.addEventListener('submit', function(e){
e.preventDefault();
add_image();
});

function add_image(){
  let data = new FormData();

  data.append('image', add_image_form.elements['image'].files[0]);
  data.append('package_id', add_image_form.elements['package_id'].value);
  data.append('add_image','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);

  
  xhr.onload = function(){
  
    
    if(this.responseText == 'inv_img'){
      alert('error','Only .jpg, .webp and .png formats are allowed!','image-alert');
    }else if(this.responseText == 'inv_size'){
      alert('error','Size should be less then 5 MB','image-alert');
    }else if(this.responseText == 'upd_failed'){
      alert('error','Image upload failed!','image-alert');
    }else{
      alert('success','Image Added','image-alert');
      package_images(add_image_form.elements['package_id'].value, document.querySelector("#package-images .modal-title").innerText);
      add_image_form.reset();
      
    }
  }
  xhr.send(data);
}

function package_images(id,rname){
  document.querySelector("#package-images .modal-title").innerText = rname;
  add_image_form.elements['package_id'].value = id;
  add_image_form.elements['image'].value = '';

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

    document.getElementById('package-image-data').innerHTML = this.responseText;

  }


  xhr.send('get_package_images='+id);


}

function rem_image(img_id,package_id){
  let data = new FormData();

  data.append('image_id', img_id);
  data.append('package_id', package_id);
  data.append('rem_image','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);

  
  xhr.onload = function(){
  
    
    if(this.responseText == 1){
      alert('success','Image Removed','image-alert');
      package_images(package_id, document.querySelector("#package-images .modal-title").innerText);
    }else{
      alert('error','Image Removal Failed','image-alert');
      
    }
  }
  xhr.send(data);
}

function thumb_image(img_id,package_id){
  let data = new FormData();

  data.append('image_id', img_id);
  data.append('package_id', package_id);
  data.append('thumb_image','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/package.php",true);

  
  xhr.onload = function(){
  
    
    if(this.responseText == 1){
      alert('success','Image Thumbnail Changed','image-alert');
      package_images(package_id, document.querySelector("#package-images .modal-title").innerText);
    }else{
      alert('error','Image Thumbnail Update Failed','image-alert');
      
    }
  }
  xhr.send(data);
}

function remove_package(package_id){

  if(confirm("Are you sure? Do you really want to delete this room?"))
  {
    let data = new FormData();
    
    data.append('package_id', package_id);
    data.append('remove_package','');


    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/package.php",true);

    
    xhr.onload = function(){
      if(this.responseText == 1){
        alert('success','Package/Room Successfully Removed');
        get_packages();
      }else{
        alert('error','Package/Room Removal Failed'); 
      }
    }
    xhr.send(data);
  }
}

window.onload = function(){
  get_packages();
}


