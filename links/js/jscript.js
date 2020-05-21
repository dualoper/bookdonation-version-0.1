// for book donation 
function change_category(){
    var x = document.getElementById("category").value;
    
    if(x === "Education"){
        document.getElementById("class_div").setAttribute("class", "col-md mb-4 from-group");
        document.getElementById("subject_div").setAttribute("class", "col-md mb-4 from-group");								
    }
    else{
        document.getElementById("class_div").setAttribute("class", "col-md mb-4 from-group d-none");
        document.getElementById("subject_div").setAttribute("class", "col-md mb-4 from-group d-none");
    }
}

function showLogin(){
    document.getElementById("logindiv").setAttribute("class","col-md-7 bg-orange shadow-blue p-5 w3-animate-zoom d-block my-5");
    document.getElementById("signupdiv").setAttribute("class","col-md-7 bg-orange shadow-blue p-5 w3-animate-zoom d-none");
}

function showSignup(){
    document.getElementById("logindiv").setAttribute("class","col-md-7 bg-orange shadow-blue p-5 w3-animate-zoom my-5 d-none");
    document.getElementById("signupdiv").setAttribute("class","col-md-7 bg-orange shadow-blue p-5 w3-animate-zoom d-block");
}

