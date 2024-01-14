const baseUrlSerivice = 'https://services-testing.babilonia.io/';

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
                            baseURL: baseUrlSerivice,
                            headers: {
                                'Accept-Language': 'es',
                                'accept': 'application/json'
                            }
                        });

    if(method == "POST"){
        return serviceHttp.post(url, { params: data }).catch(function (error) {
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
            per_page:1500,
            keyword: keyword 
        };
                
        const data = await fetchData('/app/search_users', params, 'GET');
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