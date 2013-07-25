(function(){

 //total number of files to be uploaded
 var totalFiles = 0;
 var uploadedFiles = 0;
 var files = '';   
// getElementById
function $id (id) {
    return document.getElementById(id);
}

// output information
function Output (msg) {
    var m = $id("messages");
    m.innerHTML = msg + m.innerHTML;
}

// file drag hover
function FileDragHover (e) {
    e.stopPropagation();
    e.preventDefault();
    e.target.className = (e.type == "dragover" ? "hover" : "");
}

// file selection
function FileSelectHandler (e) {
    //cancel event and hover styling
    FileDragHover(e);
    //fetch FileList object
    files = e.target.files || e.dataTransfer.files;
    totalFiles = files.length;
    $('.progress .bar').css('width', '0%');
    $('#system').val('');
    //process all file objects
    for (var i = 0,f; f = files[i]; i++) {
        ParseFile(f);
        //UploadFile(f);
    }
    
}

//file upload handler
function FileUploadHandler (e) {
    e.stopPropagation();
    e.preventDefault();
    //check if a system has been defined, otherwise display error
    if($('#system').val()==''){
        $('#meas_system').addClass('control-group error');
        $('#meas_system span').removeClass('hidden');
        if(files != ''){
            $('#submitbutton').removeClass('control-group error');
            $('#submitbutton span').addClass('hidden');
        }
    }
    //check if any files have been selected, otherwise display error
    if(files==''){
        $('#submitbutton').addClass('control-group error');
        $('#submitbutton span').removeClass('hidden');
        if($('#system').val()!=''){
            $('#meas_system').removeClass('control-group error');
            $('#meas_system span').addClass('hidden');
        }
        
    }
    //if everything is correct, remove errors and upload files
    if($('#system').val()!='' && files != ''){
     
        $('#meas_system').removeClass('control-group error');
        $('#meas_system span').addClass('hidden');
        $('#submitbutton').removeClass('control-group error');
        $('#submitbutton span').addClass('hidden');
        totalFiles = files.length;
   
    //process all file objects
    for (var i = 0,f; f = files[i]; i++) {
        //ParseFile(f);
        UploadFile(f);

    }
    $("#fileuploadlist").empty();
    files = '';
    
}
}
//total progress bar
function progressBar (i) {
    var progress = document.getElementsByClassName("bar")[0];
    
    if(uploadedFiles=="0"){
        
        $('.progress .bar').css('width', '0%');
    }

    var pc = parseInt((i / totalFiles+1*100));
    
    $('.progress .bar').css('width', pc + '%');

    if(i==totalFiles-1){
        var o = $id("total");
        var total = o.appendChild(document.createElement("p"));
        total.appendChild(document.createTextNode(uploadedFiles+1 +" files successfully uploaded."));
        i=0;
        totalFiles = 0;
        uploadedFiles = 0;
        
    }
        
    
}
// parse files to diplay
function ParseFile (file) {
    
    var type, ext = file.name.split('.').pop();
    var o = $id("fileuploadlist");
    
    var filename = o.appendChild(document.createElement("p"));
    filename.appendChild(document.createTextNode(file.name));
    
}

//upload file asynchronously
function UploadFile (file) {
    var xhr;
    var ext = file.name.split('.').pop();
     if(window.XMLHttpRequest)
     {
        //under IE7+, chrome, FF, opera, safari
        xhr = new XMLHttpRequest();
     }
     else{
        //IE6/5
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }

     if(xhr.upload){
        //create progress bar
        var o = $id("messages");
        var message = o.appendChild(document.createElement("p"));
        message.id=file.name;
       
        //progress bar
        xhr.upload.addEventListener("progress",function(e){
            //var pc = parseInt(100 - (e.loaded / e.total*100));
            //progress.style.backgroundPosition = pc + "% 0";
        },false);
        //file received/failed
        xhr.onreadystatechange = function(e){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
                if(xhr.responseText == "exists"){
                    message.className = "failure";
                    message.appendChild(document.createTextNode(file.name +"..... already in database"));
                    uploadedFiles++;
                }
                else{
                    message.className = "success";
                    message.appendChild(document.createTextNode(file.name +".......success"));
                    //var bar = document.getElementById(file.name);
                    //var temp = o.removeChild(bar);
                    uploadedFiles++;
                    progressBar(uploadedFiles);
                   
                }
                
            }
            else{
                message.className = "failure";
            }
        };
        //start upload
        //get data
        var form = $id('fileupload');
        var data = new FormData(form);
        //console.log(form);
        data.append('file',file);
        //console.log(otherData);
        //post data to server
        xhr.open("POST", "server/upload_file.php", true);
        xhr.setRequestHeader("X_FILENAME",file.name);
        xhr.send(data);
        
     }
    
}

//initialize
function Init () {
    
    var fileselect = $id("fileselect"),
        filedrag = $id("filedrag"),
        submitbutton = $id("submitbutton");
    //process the file if the user uses the choose files button rather than drag drop
    fileselect.addEventListener("change", FileSelectHandler, false);
    //is XHR2 available?
    
    filedrag.style.display = "block";
    var xhr = new XMLHttpRequest();
    if(xhr.upload){
        //file drop
        filedrag.addEventListener("dragover", FileDragHover, false);
        filedrag.addEventListener("dragleave", FileDragHover, false);
        filedrag.addEventListener("drop", FileSelectHandler, false);
        submitbutton.addEventListener("click", FileUploadHandler, false);
        //remove submit button
        //submitbutton.style.display="none";
        //var q = $id("total_progress");
        //var progress = q.appendChild(document.createElement("p"));
        
    }
}

 //call init for file upload file
if(window.File && window.FileList && window.FileReader){
   Init();
   
}
})();