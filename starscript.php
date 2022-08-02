<style>

/* - - - - - RATINGS */
.rating {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 300px; /*150px*/
  height: 50px;
  padding: 5px 80px; /*5px 10px*/
  margin: auto; 
  margin-left: 50px;
  display: inline;
  overflow: hidden;
  
 
  unicode-bidi: bidi-override;
  direction: rtl;
}
.rating:not(:checked) > input {
  display: none;
}


/* - - - - - LIKE */
#like {
  /*bottom: -65px;*/
  
}
#like:not(:checked) > label {
  cursor:pointer;
  float: right;
  width: 27px;  /*25*/
  height: 100px;
  display: block;
  
  color: rgba(0,100,0, .4);
  line-height: 33px;
  text-align: center;
}
#like:not(:checked) > label:hover,
#like:not(:checked) > label:hover ~ label {
  color: rgba(0,100,0, .6);
}
#like > input:checked + label:hover,
#like > input:checked + label:hover ~ label,
#like > input:checked ~ label:hover,
#like > input:checked ~ label:hover ~ label,
#like > label:hover ~ input:checked ~ label {
  color: rgba(0,100,0, .8);
}
#like > input:checked ~ label {
  color: rgb(0,100,0);

}
</style>