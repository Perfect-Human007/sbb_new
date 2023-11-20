

let add_branch_form = document.getElementById('add_branch_form');

add_branch_form.addEventListener('submit', function(e){
e.preventDefault();
add_branch();
})

function add_branch()
{

  let data = new FormData();
  data.append('name', add_branch_form.elements['name'].value);
  data.append('address', add_branch_form.elements['address'].value);
  data.append('desc', add_branch_form.elements['desc'].value);
  data.append('add_branch','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);


  xhr.onload = function(){

    var myModal = document.getElementById('add-branch')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1){
    alert('success','New branch Added');
    add_branch_form.reset();
    
    }else{
    alert('error','Server down!');
    }
    get_branches();
  }
  xhr.send(data);
} 

function get_branches()
{
 
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

    document.getElementById('branch-data').innerHTML = this.responseText;


  }


  xhr.send('get_branches');
}


let edit_branch_form = document.getElementById('edit_branch_form');
function edit_details(id)
{
  
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

  let data = JSON.parse(this.responseText);
  edit_branch_form.elements['name'].value = data.branchdata.name;
  edit_branch_form.elements['address'].value = data.branchdata.address;
  edit_branch_form.elements['desc'].value = data.branchdata.description;
  edit_branch_form.elements['branches_id'].value = data.branchdata.id;
  
  
  }


  xhr.send('get_branch='+id);
}

edit_branch_form.addEventListener('submit', function(e){
e.preventDefault();
submit_edit_branch();
})

function submit_edit_branch()
{

  let data = new FormData();
  data.append('name', edit_branch_form.elements['name'].value);
  data.append('address', edit_branch_form.elements['address'].value);
  data.append('desc', edit_branch_form.elements['desc'].value);
  data.append('edit_branch','');
  data.append('branches_id',edit_branch_form.elements['branches_id'].value);

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);

 
  xhr.onload = function(){

    var myModal = document.getElementById('edit-branch')
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1){
    alert('success','Branch info has been edited');
    edit_branch_form.reset();
    get_branches();
    
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
  data.append('branch_id', add_image_form.elements['branch_id'].value);
  data.append('add_image','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);

  
  xhr.onload = function(){
  
    
    if(this.responseText == 'inv_img'){
      alert('error','Only .jpg, .webp and .png formats are allowed!','image-alert');
    }else if(this.responseText == 'inv_size'){
      alert('error','Size should be less then 5 MB','image-alert');
    }else if(this.responseText == 'upd_failed'){
      alert('error','Image upload failed!','image-alert');
    }else{
      alert('success','Image Added','image-alert');
      branch_images(add_image_form.elements['branch_id'].value, document.querySelector("#branch-images .modal-title").innerText);
      add_image_form.reset();
      
    }
  }
  xhr.send(data);
}

function branch_images(id,rname){
  document.querySelector("#branch-images .modal-title").innerText = rname;
  add_image_form.elements['branch_id'].value = id;
  add_image_form.elements['image'].value = '';

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);
  xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  xhr.onload = function(){

    document.getElementById('branch-image-data').innerHTML = this.responseText;

  }


  xhr.send('get_branch_images='+id);


}

function rem_image(img_id,branch_id){
  let data = new FormData();

  data.append('image_id', img_id);
  data.append('branch_id', branch_id);
  data.append('rem_image','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);

  
  xhr.onload = function(){
  
    
    if(this.responseText == 1){
      alert('success','Image Removed','image-alert');
      branch_images(branch_id, document.querySelector("#branch-images .modal-title").innerText);
    }else{
      alert('error','Image Removal Failed','image-alert');
      
    }
  }
  xhr.send(data);
}

function thumb_image(img_id,branch_id){
  let data = new FormData();

  data.append('image_id', img_id);
  data.append('branch_id', branch_id);
  data.append('thumb_image','');


  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/branch.php",true);

  
  xhr.onload = function(){
  
    
    if(this.responseText == 1){
      alert('success','Image Thumbnail Changed','image-alert');
      branch_images(branch_id, document.querySelector("#branch-images .modal-title").innerText);
    }else{
      alert('error','Image Thumbnail Update Failed','image-alert');
      
    }
  }
  xhr.send(data);
}

function remove_branch(branch_id){

  if(confirm("Are you sure? Do you really want to delete this room?"))
  {
    let data = new FormData();
    
    data.append('branch_id', branch_id);
    data.append('remove_branch','');


    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/branch.php",true);

    
    xhr.onload = function(){
      if(this.responseText == 1){
        alert('success','Branch Successfully Removed');
        get_branches();
      }else{
        alert('error','Branch Removal Failed'); 
      }
    }
    xhr.send(data);
  }
}

window.onload = function(){
  get_branches();
}


