function formValidation() {
  document.getElementById("myPopup").classList.toggle('show',false);
  document.getElementById("myPopup2").classList.toggle('show',false);
  document.getElementById("myPopup3").classList.toggle('show',false);

  var arrS = document.arrayForm.arraysize.value;
  var minV = document.arrayForm.minvalue.value;
  var maxV = document.arrayForm.maxvalue.value;

if(arrS == ""|| minV == "" || maxV == "" ){
  if(arrS == ""){
    document.getElementById("myPopup").innerHTML = "*Please enter a number!";
    document.getElementById("myPopup").classList.toggle('show',true);
  }

  if(minV == "") {
    document.getElementById("myPopup2").innerHTML = "*Please enter a number!";
    document.getElementById("myPopup2").classList.toggle('show',true);

  }

  if(maxV == "") {
    document.getElementById("myPopup3").innerHTML = "*Please enter a number!";
    document.getElementById("myPopup3").classList.toggle('show',true);
  }

  return false;
}

if(isNaN(arrS) || isNaN(minV) || isNaN(maxV)) {
  if(isNaN(arrS)){
    document.getElementById("myPopup").innerHTML = "*Please enter a number!";
    document.getElementById("myPopup").classList.toggle('show',true);
  }

  if(isNaN(maxV)) {
    document.getElementById("myPopup3").innerHTML = "*Please enter a number!";
    document.getElementById("myPopup3").classList.toggle('show',true);

  }

  if(isNaN(minV)) {
    document.getElementById("myPopup2").innerHTML = "*Please enter a number!";
    document.getElementById("myPopup2").classList.toggle('show',true);
  }

  return false;
}

if(parseInt(arrS) < 1) {
    document.getElementById("myPopup").innerHTML = "*Array size must be greater than 0!"
    document.getElementById("myPopup").classList.toggle('show',true);
    return false ;
}
if(parseInt(arrS) > 10000) {
    document.getElementById("myPopup").innerHTML = "*Please choose a smaller arraysize!"
    document.getElementById("myPopup").classList.toggle('show',true);
    return false ;
}

if(parseInt(minV) > parseInt(maxV)) {
  document.getElementById("myPopup2").innerHTML = "*Minimum value must be larger than maximum value!"
  document.getElementById("myPopup2").classList.toggle('show',true);
  document.getElementById("myPopup3").innerHTML = "*Minimum value must be larger than maximum value!"
  document.getElementById("myPopup3").classList.toggle('show',true);
  return false ;
}

}
