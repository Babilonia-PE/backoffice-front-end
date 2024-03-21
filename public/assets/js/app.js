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

const fetchData = async (url = "", data = null, method = 'POST') => {   
    const serviceHttp = await axios.create({
                            baseURL: APP_BASE_EP,
                            headers: {
                                'Accept-Language': 'es',
                                'accept': 'application/json'
                            }
                        });

    if(method == "POST"){
        return serviceHttp.post(url, data).catch(function (error) {
            return error
        })
    }

    return serviceHttp.get(url, { params: data }).catch(function (error) {
        return error
    })
}
const copyToClipboard = ()=>{

    $("[data-copy]").unbind("click");
    
    $("[data-copy]").on('click', async function(e){
        try {
            await navigator.clipboard.writeText(this.getAttribute("data-value"));
            
            
            const tooltip = new bootstrap.Tooltip(e.target, {
                boundary: document.body,
                title:'Texto copiado!',
                trigger:'click'
            });
            
            tooltip.show();
            
            setTimeout(() => {                
                tooltip.hide();

                setTimeout(() => {
                    tooltip.dispose();
                }, 500);

            }, 1000);

          } catch (err) {
          }
    })    
}
const userSearch = (options = {}) => {

    const { id='user_id', storage = 'filter_leads_users' } = options;
    $(`#${id}`).selectpicker({
        liveSearch: true
    });
    $(`.${id}.user-search.bootstrap-select .bs-searchbox input`).unbind("keyup");
    $(`.${id}.user-search.bootstrap-select .bs-searchbox input`).on('keyup', async function (e) {
        let keyword = e.target.value;
        const selectUser = document.getElementById(id);

        if(keyword == "" || keyword.length < 4){
            selectUser.innerHTML="";
            $(`#${id}`).selectpicker('refresh');
            return false;
        }
        let params = {
            page:1,
            per_page: 100,
            keyword: keyword,
            parent: 'user',
            child: 'search'
        };
                
        const data = await fetchData('/app/gateway', params, 'GET');
        const records = data.data?.data?.records ?? [];
        selectUser.innerHTML="";
        if(records.length > 0){
            localStorage.setItem(storage, JSON.stringify(records));
            records.forEach((item) => {
                let option = document.createElement("option");
                option.value = item.id;
                option.innerHTML = `${item.full_name} - ${item.email}`;
                selectUser.append(option);
            });
        }
        $(`#${id}`).selectpicker('refresh');
    });
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

//script active menu para categoria superiores

const setActiveMenu = (nav = null)=> {

    let parentLi = null;
    let parentUl = null;

    let navActive = (nav == null) ? document.querySelector("ul.nav-sidebar a.active") : nav;
    if(navActive == null) return false;

    parentLi = navActive.parentElement;
    parentUl = parentLi.parentElement;

    if(!parentUl.classList.contains('nav-sidebar')){
        parentLi = parentUl.parentElement;
        parentUl = parentLi.parentElement;
        let nav = parentUl.querySelector("a.nav-link");

        if(!parentUl.classList.contains('nav-sidebar')){
            setActiveMenu(nav);
        }else{
            parentLi.querySelector("a.nav-link").classList.add("active");
            parentLi.classList.add('menu-open');
        }
    }
}
window.alertShort =  async function alertShort(jsType, jsTitle, jsMsg = '', jsMultiple = false, styles = {} ) {
    if( !$(".alertShort-container").length ){
        jQuery('<div>', {
            'class': 'alertShort-container'
        }).appendTo("body")
    }
    const icons = { 'error': 'babilonia-cross', 'success': 'babilonia-check1', 'warning': 'babilonia-question'}
    if (jsMultiple) {
        await Promise.all(Object.entries(jsMsg).map(async ([jsKey, jsValue]) => {
            const html = `
                <div class="alertShort" style="${styles.mainstyles}">
                    <div class="circle ${jsType}">
                        <div class="${icons[jsType]}"></div>
                    </div>
                    <div class="details">
                        <p>${jsTitle}</p>
                        <span style="${styles.msgstyles}">${jsValue}</span>
                    </div>
                </div>`;
            $(".alertShort-container").append(html);
        }));
    }else{
        const html = `
            <div class="alertShort" style="${styles.mainstyles}">
                <div class="circle ${jsType}">
                    <div class="${icons[jsType]}"></div>
                </div>
                <div class="details">
                    <p>${jsTitle}</p>
                    <span style="${styles.msgstyles}">${jsMsg}</span>
                </div>
            </div>`;
        $(".alertShort-container").append(html);
    }
    setTimeout(function () {
        $('.alertShort-container').remove();
    }, 6000);

    $(".alertShort").on("click", function(){
        $(this).remove();
    })
}
const getFlag = (flag = null) => {
    if(flag == null || flag == '' || flag == 'Null') return '';
    
    return `<span class="f16 align-middle-flag"><i class=" inline-flag flag ${flag}"></i></span>`;
}
const getFullNumber = (flag = null, number = null) => {
    return `${getFlag(flag)} ${number??''}`;
}
const toCamelCase = (inputString = null) => {
    if(inputString == '' || inputString == null) return '';

    return inputString.replace(/(?:^\w|[A-Z]|\b\w)/g, function (word, index) {
        return index == 0 ?  word.toUpperCase() : word.toLowerCase();
    }).replace(/\s+/g, '');
}
setActiveMenu();

$(document).on("click", ".buttons-colvis", async function() {
    const table = $(".dataTables_wrapper");
    const btn = $(".dt-button-collection");
    console.log( btn.height() + " " + table.height() );
    if( btn.height() > table.height() ){
        $("body").addClass("colvis-btn");
    }
});
$(document).on("DOMNodeRemoved", function(e){
    if( $(e.target).attr('class') == 'dropdown-menu dt-button-collection' ){
        $("body").removeClass("colvis-btn");
    }
});
//MOSTRAR MENSAJES SI LOS HUBIESE
const showMessage = (name = 'message') => {
    let message = localStorage.getItem(name);
    if( message ){
        alertShort('success', message);
    }
    localStorage.removeItem("message");
}
//VERIFICACIÓN DE CÓDIGO
window.AppValidateHttpCode = async function (jsData, jsRedirect = false) {
    try {
        let jsStatus = jsData.response.status
        switch (jsStatus) {
            case 401:
                AppHttpServicePageUnauthorized(jsRedirect);
                break;
            case 400:
                AppHttpServiceBadRequest(jsData);
                break;
            case 404:
                AppHttpServicePageNotFound();
                break;
            case 408:
                AppHttpErrorNetwork();
                break;
            case 500:
                HttpServicePageServerInternal();
                break;
            case 501:
            case 502:
            case 503:
            case 504:
                AppHttpServicePageUnable();
                break;
            default:
                AppHttServicePageOutRange(jsStatus);
        }
    } catch (error) {
        AppHttpErrorNetwork();
    }
}
//VALIDAR CODIGO HTTP
window.AppHttpServicePageUnauthorized = function(jsRedirect = false)  {
    if (jsRedirect){
        window.location.replace(URL_SIGN_IN);
    }
}
window.AppHttpServicePageUnable = function ()   {
    console.log('Service Unable');
}
window.AppHttpErrorNetwork = function()  {
    let no_message = new URLSearchParams(window.location.search).get("no_message");    
    if(no_message==null)alertShort('error','Error Network','' );
}
window.AppHttServicePageOutRange = function(expr)  {
    let no_message = new URLSearchParams(window.location.search).get("no_message");    
    if(no_message==null)alertShort('error', 'Error Network', expr);
}
window.AppHttpServiceBadRequest = function (jsResponse)  {
    if( jsResponse.hasOwnProperty('response')){
        try {
            let jsData = jsResponse.response;
            if ((jsData.data.data).hasOwnProperty('errors')){
                if (jsData.data.data.errors[0].key === 'authorization'){
                    localStorage.clear();
                    window.location.replace(URL_SIGN_IN);
                }
                if ( (jsData.data.data.errors[0]).hasOwnProperty('message')   )
                {
                    let msg = jsData.data.data.errors[0].message === null?'':jsData.data.data.errors[0].message;
                    alertShort('error','Datos Invalidos', msg );
                }
            }
        }
        catch(err) {
            let errors = err;
            if(isTesting) console.log(errors);
        }
    }
}
window.AppHttpServicePageNotFound = function ()  {
    console.log('Service not Found');
}
window.AppHttpServicePageServerInternal = function () { }