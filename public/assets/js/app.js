window.setMask = (selector, mask) => {
    let item = $(selector);
    if( item.attr("maxlength") ){
        let maxlength = item.attr("maxlength");
        let newMaxLength;
        let alias = mask.alias??"";
        newMaxLength = Number(maxlength) + Number((mask.prefix??"").length) + Number((mask.suffix??"").length);
        if(alias === "currency"){
            newMaxLength += Math.round(maxlength/4);
        }
        item.attr("maxlength", newMaxLength)
    }
    mask.oncleared = function() {
        let el = item;
        if( el.val() === "" || el.val() == (( mask.prefix??"" ) + ( mask.suffix??"" ))){
            el.val("")
        }
    }
    mask.onKeyDown = (event) => {
        if (event.key == 'Delete' || event.key == 'Backspace') {
            let el = event.target;
            if ( el.value == ( mask.prefix??"" ) + '0' + ( mask.suffix??"" ) ) {
                el.value = '';
            }
        }
    }
    mask.showMaskOnFocus = false;
    mask.showMaskOnHover = false;
    item.inputmask(mask);
}
const fetchData = async (url = "", data = {}, method = 'POST') => {    
    const response = await fetch(url, {
      method,
      mode: "cors",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      redirect: "follow",
      referrerPolicy: "no-referrer",
      body: JSON.stringify(data),
    });
    const json = await response.json();
    return json;
}