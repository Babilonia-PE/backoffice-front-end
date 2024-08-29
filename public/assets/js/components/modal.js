
export class Modal {
    modalWrap;
    structure;
    functions;
    hidden;
    identity;
    remove = true;
    constructor( structure = {}, functions = {}, hidden = false ) {
        this.structure = structure;
        this.functions = functions;
        this.hidden = hidden;
        this.create();
    }
    create = async () => {
        if(!this.modalWrap){
            const type = this.structure.type??'modal';
            const component = await fetch(`/public/assets/templates/modal/${type}.hbs`)
            this.identity = ( this.structure.identity ) ? this.structure.identity : Math.random().toString(36).slice(2, 7);
            this.modalWrap = document.createElement('div');
            this.structure.identity = this.identity;
            const texto = await component.text();
            const template = Handlebars.compile(texto);
            const html = template(this.structure);
            const options = this.structure.options??null;
            const eternal = options?.eternal??false;
            this.modalWrap.innerHTML = html;
            document.body.append(this.modalWrap);
            if( type === 'onetap' || type === 'loader' ){
                return false;
            }
            const selector = this.modalWrap.querySelector('.modal');
            const modal = new bootstrap.Modal(selector, options);
            const btnsuccess = selector.querySelector('.modal-success-btn');
            const btnCancel = selector.querySelector('.modal-cancel-btn');
            const functions = this.functions;
            if( eternal ){
                const elements = selector.querySelectorAll('[data-bs-dismiss]');
                console.log(elements);
                Array.from(elements).forEach((element, index) => {
                    element.removeAttribute("data-bs-dismiss");
                });
            }
            if( btnsuccess ){
                btnsuccess.onclick = async function(){
                    if(functions.success?.close??true){
                        modal.hide();
                    }
                    if (functions.hasOwnProperty('success')){
                        let loaderWrap
                        if(functions.success.loader??false){
                            loaderWrap = new Loader();
                        }
                        if ( typeof functions.success.function == 'function' ) { 
                            try {
                                await functions.success.function(); 
                                if( loaderWrap ){ loaderWrap.destroy(); }
                            } catch (error) {
                                console.log(error);
                                if( loaderWrap ){ loaderWrap.destroy(); }
                            }
                        }
                    }
                };
            }
            if( btnCancel ){
                btnCancel.onclick = async function(){
                    if(functions.cancel?.close??true){
                        $(selector).modal('hide');
                    }
                    if (functions.hasOwnProperty('cancel')){
                        let loaderWrap
                        if(functions.cancel.loader??false){
                            loaderWrap = new Loader();
                        }
                        if ( typeof functions.cancel.function == 'function' ) { 
                            try {
                                await functions.cancel.function(); 
                                if( loaderWrap ){ loaderWrap.destroy(); }
                            } catch (error) {
                                console.log(error);
                                if( loaderWrap ){ loaderWrap.destroy(); }
                            }
                        }
                    }   
                };
            }
            $(selector).on('show.bs.modal', async function () {
                if (functions.hasOwnProperty('show')){
                    if ( typeof functions.show.function == 'function' ) { 
                        try {
                            await functions.show.function(); 
                        } catch (error) {
                            console.log(error);
                        }
                    }
                }  
            })
            $(selector).on('shown.bs.modal', async function () {
                if (functions.hasOwnProperty('shown')){
                    if ( typeof functions.shown.function == 'function' ) { 
                        try {
                            await functions.shown.function(); 
                        } catch (error) {
                            console.log(error);
                        }
                    }
                }  
            })
            $(selector).on('hide.bs.modal', async function () {
                if (functions.hasOwnProperty('hide')){
                    if ( typeof functions.hide.function == 'function' ) { 
                        try {
                            await functions.hide.function(); 
                        } catch (error) {
                            console.log(error);
                        }
                    }
                }  
            })
            $(selector).on('hidden.bs.modal', async function () {
                if( this.remove && !this.hidden ){
                    this.parentElement.remove();
                    this.modalWrap = null;
                }
                if (functions.hasOwnProperty('hidden')){
                    if ( typeof functions.hidden.function == 'function' ) { 
                        try {
                            await functions.hidden.function(); 
                        } catch (error) {
                            console.log(error);
                        }
                    }
                }  
            })
            modal.show();
        }else{
            console.log("modal ya creado.");
        }
    }
    show = () => {
        if(this.modalWrap){
            this.remove = true;
            if( $(this.modalWrap).find(".modal").length ){
                $(this.modalWrap).find(".modal").modal('show');
            }else{
                $(this.modalWrap).show();
            }
        }else{
            console.log("Debe incializar el modal para poder usar este metodo.");
        }
    }
    hide = (remove = false) => {
        this.remove = remove;
        if( $(this.modalWrap).find(".modal").length ){
            if( this.modalWrap ) $(this.modalWrap).find(".modal").modal('hide');
        }else{
            if( this.modalWrap ) $(this.modalWrap).hide();
        }
    }
    destroy = () => {
        if( this.modalWrap ) $(this.modalWrap).remove();
        this.modalWrap = null;
    }
}
export class ModalStepper {
    #modalWrap;
    #structure;
    #functions;
    #identity;
    #remove = true;
    packages;
    constructor() {
        // El constructor de esta clase debe estar vacia debido a que no se deben inicializar las variables y metodos
    }
    static async new( structure = {}, functions = {} ) {
        const stepper = new ModalStepper()
        await stepper.create( structure, functions );
        return stepper;
    }
    static async newPlan() {
        const structure = {
            path: 'planStepper',
            type: 'index',
            babilonia_label_default,
            options: {
                backdrop: 'static',
                keyboard:  false,
                focus: true
            }
        };
        const functions = {
            show : {
                function: async () => {
                    if(isTesting) console.log("generando recaptcha...");
                    // const { generate } = recaptcha();
                    // await generate();
                }
            },
            shown: {
                function: async () => {
                    $('.grid').flickity({
                        cellAlign: 'left',
                        contain: true,
                        pageDots: false,
                        nav:false,
                        items: 1,
                        adaptiveHeight: true,
                    });
                }
            }
        }
        const language = {
            "essentials": "Básico", 
            "pro": "Destacado", 
            "prestige": "Avanzado"
        }
        const serviceHttp = await AppService();
        // const { process } = recaptcha();
        let profile, packages_data, payment_intent,  data_step = {}, FormPayment = {};
        const actions = {
            step1: () => {
                $('input[type=radio][name="type[]"]').change(function() {
                    if (this.value == '1') {
                        $(".btn-action").attr("disabled", false);
                        $(".btn-action").unbind("click");
                        $(".btn-action").on("click", async function(){
                            let validated = await AppVerifyAuth();
                            if (validated) {
                                window.location = URL_LISTING_NEW;
                            } else {
                                window.location = URL_SIGN_IN;
                            }
                        });
                    }else if (this.value == '2') {
                        $(".btn-action").attr("disabled", false);
                        $(".btn-action").unbind("click");
                        $(".btn-action").on("click", async function(){
                            window.location.href = 'contratar-plan';
                            return;
                        });
                    }else if (this.value == '3') {
                        $(".btn-action").attr("disabled", false);
                        $(".btn-action").unbind("click");
                        $(".btn-action").on("click", async function(){
                            window.location = 'contact';
                        });
                    }
                });
            },
            step2: () => {
                $(".package-more span").on("click", function(){
                    if( $(this).attr("data-action") === "true" ){
                        $(this).attr("data-action", false);
                        jQuery('<a>', {
                            "href": "contact",
                            "target": "_blank",
                            "text": "Si estás interesado en más avisos, haz click aquí."
                        }).appendTo('.package-more');
                        $(this).text("Mostrar menos.");
                        $(".package").css({"display": "flex"});
                    }else{
                        $(this).attr("data-action", true);
                        $(this).text("Mostrar más.");
                        $(".package-more").find("a").remove();
                        $(".package").removeAttr("style");
                    }
                });
                $(".details-box-show").on("click", function(){
                    if( $(this).attr("data-action") === "true" ){
                        $(this).attr("data-action", false);
                        $(this).find(".babilonia").removeClass("babilonia-angle-down");
                        $(this).find(".babilonia").addClass("babilonia-angle-up");
                        $(".details-box").css({"display": "grid"});
                    }else{
                        $(this).attr("data-action", true);
                        $(this).find(".babilonia").removeClass("babilonia-angle-up");
                        $(this).find(".babilonia").addClass("babilonia-angle-down");
                        $(".details-box").removeAttr("style");
                    }
                });
                $('input[type=radio][name="optionpackage[]"]').change(function() {
                    const target = $(this).val();
                    $(".category").css({"display": "none"});
                    $(".category[data-id=" + target + "]").css({"display": "grid"});
                });
                $(".btn-back").on("click", async function(){
                    const structure = { path: 'planStepper', type: 'step1', babilonia_label_default }
                    await stepper.change(structure);
                    actions.step1();
                });
                $(".btn-action").on("click", async function(){
                    try {
                        const box = $(".category:visible")
                        const id = box.attr("data-id");
                        const position = box.find('input[type=radio]:checked').val();
                        const index = packages_data.findIndex(x => x.id === Number(id));
                        const item = packages_data[index].packages[position];
                        const data = {
                            ads_count: packages_data[index].ads_count,
                            category: item.category,
                            category_name: language?.[item.category]??category,
                            standard_ads_count: item.standard_ads_count,
                            plus_ads_count: item.plus_ads_count,
                            premium_ads_count: item.premium_ads_count,
                            products: item.products.map((product)=>{
                                return {
                                    key: product.key,
                                    duration: product.duration,
                                    price: 'S/' + Number(product.price??0).toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }),
                                };
                            })
                        }
                        FormPayment.package = id
                        FormPayment.ads_count = packages_data[index].ads_count;
                        FormPayment.category = item.category;
                        FormPayment.products = item.products;
                        data_step.step3 = data;
                        const structure = { path: 'planStepper', type: 'step3', ...data_step.step3 }
                        await stepper.change(structure);
                        actions.step3();
                    } catch (error) {
                        if(isTesting) console.log(error);
                        const structure = { path: 'planStepper', type: 'step1', babilonia_label_default }
                        await stepper.change(structure);
                        actions.step1();
                    }
                });
            },
            step3: () => {
                $(".btn-back").on("click", async function(){
                    const structure = { path: 'planStepper', type: 'step2', packages: packages_data }
                    await stepper.change(structure);
                    actions.step2();
                });
                $("#code_discount").on("blur input keyup change", function() {
                    if($(this).val().length > 3 ){
                        $(".applycuppons").attr("disabled", false);
                    }else{
                        $(".applycuppons").attr("disabled", true);
                    }
                });
                $(".applycuppons").click(async function () {
                    FormPayment.code_discount = $("#code_discount").val();
                    const formData = {
                        category: FormPayment.category,
                        code: FormPayment.code_discount,
                        package_group: FormPayment.package,
                        request: "discount"
                    };
                    const loader = new Loader()
                    const jsDataDiscounts = await loadCuppons(serviceHttp, formData);
                    loader.destroy();
                    if (jsDataDiscounts.hasOwnProperty('code')) {
                        return false;
                    }
                    const discount = jsDataDiscounts?.data??[];
                    //$("#titlediscount").text(`Disfruta del ${discount.discount}% de descuento en todos los plazos`);
                    //console.log(jsDataDiscounts);
                })
                $(".btn-action").on("click", async function(){
                    try {
                        profile = await savedb(DB_NAME.PROFILE, AppLoadProfile);
                        const input = $('input[type=radio][name="Period"]:checked');
                        const code_discount = $("#code_discount").val();
                        const index = FormPayment.products.findIndex(x => x.key === input.val());
                        const item = FormPayment.products[index];
                        const data = {
                            ads_count: FormPayment.ads_count,
                            category: FormPayment.category,
                            category_name: language?.[FormPayment.category]??FormPayment.category,
                            duration: item.duration,
                            price: 'S/' + Number(item.price??0).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                        }
                        data_step.step4 = data;
                        const intent = {
                            client_id: profile.data.data.id,
                            discount: code_discount === null ? '' : code_discount,
                            product_key: item.key,
                            request: 'package'
                        }
                        const result_intent = await paymentIntent(serviceHttp, intent);
                        payment_intent = result_intent?.data?.data??[];
                        const structure = { path: 'planStepper', type: 'step4', ...data_step.step4 }
                        await stepper.change(structure);    
                        actions.step4();
                    } catch (error) {
                        if(isTesting) console.log(error);
                        const structure = { path: 'planStepper', type: 'step1', babilonia_label_default }
                        await stepper.change(structure);
                        actions.step1();
                    }
                });
            },
            step4: () => {
                let payment_type = 'card';
                let document_type = 'ticket';
                let validate = true;
                const length = { "inputnumbercard": 19, "inputexpirecard": 5, "inputccvcard": 3, "inputnamecard": 5 }
                $(".btn-back").on("click", async function(){
                    const structure = { path: 'planStepper', type: 'step3', ...data_step.step3 }
                    await stepper.change(structure);
                    actions.step3();
                });
                $("#card").on("click", async function(){
                    payment_type = 'card';
                    validate = true;
                    $(".form input").val("");
                    $(".btn-action").attr("disabled", true);
                });
                $("#transfer").on("click", async function(){
                    payment_type = 'transfer';
                    validate = false;
                    $(".btn-action").attr("disabled", false);
                });
                $("#document_type").on("click", async function(){
                    if ($(this).is(':checked')) {
                        if (profile.data.data.company === null || profile.data.data.company.company_id === '') {
                            alertShort('error', 'Perfil sin empresa.', 'Actualice su perfil.')
                            $(this).prop('checked', false);
                            return;
                        }
                        document_type = 'invoice';
                    }else{
                        document_type = 'ticket';
                    }
                });
                $(".form").find("input").each(function( index, value ) {
                    let field = $(this);
                    field.on("blur input keyup change", function() {
                        if( validate ){
                            let submitButton = false;
                            $(".form").find("input").each(function( index, value ) {
                                let element = $(value);
                                let id = element.attr("id");
                                if( element.val().length < length[id] ){
                                    submitButton = true;
                                }
                            });
                            $(".btn-action").attr("disabled", submitButton);
                        }
                    });
                });
                $(".btn-action").on("click", async function(){
                    try {
                        const cvv = $("#inputccvcard").val();
                        const expired = $("#inputexpirecard").val();
                        const name = $("#inputnamecard").val();
                        const card = $("#inputnumbercard").val();
                        const formData = {
                            card_cvv: cvv??'',
                            card_expiration: expired??'',
                            card_name: name??'',
                            card_number: card?.replaceAll(" ", "")??'',
                            device_session_id: payment_intent.device_session_id,
                            deviceSessionId: payment_intent.deviceSessionId,
                            notProcess: true,
                            order_id: payment_intent.order_id,
                            payment_type: payment_type,
                            payment_intent_id: payment_intent.paymentIntentId,
                            document_type: document_type
                        };
                        // await process();
                        stepper.destroy();
                        const loader = new Loader()
                        let responsePay = await paymentProcess(serviceHttp, formData);
                        if (responsePay.hasOwnProperty('code')) {
                            AppValidateHttpCode(responsePay, true);
                            loader.destroy();
                            return false;
                        }else{
                            try {
                                if (responsePay.data.data.status === 'ok') {
                                    alertShort('success', responsePay.data.data.message, 'Redireccionando...');
                                    window.location = URL_MY_LISTINGS;
                                }
                            } catch (err) {
                                alertShort('error', '[Tipo de tarjeta] es inválida', '');
                                loader.destroy();
                                return false;
                            }
                        }
                        loader.destroy();
                    } catch (error) {
                        if(isTesting) console.log(error);
                    }
                    
                });
                setMask('#inputnumbercard', { mask: "9999 9999 9999 9999", placeholder: "", rightAlign:false });
                setMask('#inputexpirecard', { mask: "99/99", placeholder: "", rightAlign:false });
                setMask('#inputccvcard', { mask: "9999", placeholder: "", rightAlign:false });
            }
        }
        const stepper = new ModalStepper()
        await stepper.create( structure, functions );
        actions.step1();
        return stepper;
    }
    static async newAlert(type = "listing") {
        /* cerrar offcanvas si esta abierto */
        if($(".offcanvas.show").length) $(".offcanvas.show [data-bs-dismiss='offcanvas']").click();
        /* cerrar custom oauth si esta abierto */
        if($(".one-tap-popup").length) $(".one-tap-popup #close-popup").click();

        let dataTemp = null;
        const servicePaginate = await loadAlertService(type);
        const currency = localStorage.getItem("dbcurrencyProject");
        const auth = await AppVerifyAuth();
        const { process, generate } = recaptcha();
        const { loadPrefix, getCodeNumberSelected } = helperPrefix();
        const isproject = (type == "listing") ? null : true;
        const property_types = (() => {
            if (type == "listing") {
                return servicePaginate.data.data.property_types??[];
            } else {
                return servicePaginate.data.data.project_types??[];
            }
        })();
        const listing_types = (() => {
            if (type == "listing") {
                return servicePaginate.data.data.listing_types.filter((item)=>item.code != 'all');
            } else {
                return servicePaginate.data.data.stages.filter((item)=>item.code != 'all');
            }
        })();
        const price_sale = (() => {
            if (type == "listing") {
                return servicePaginate.data.data.price_sale;
            } else {
                const price = ( ( currency??0 ) == 0 ) ? servicePaginate.data.data.price_pen : servicePaginate.data.data.price_usd;
                return price;
            }
        })();
        
        const price_rent = (() => {
            if (type == "listing") {
                return servicePaginate.data.data.price_rent;
            } else {
                return null;
            }
        })();
        const structure = {
            path: 'alertStepper',
            type: 'index',
            options: {
                backdrop: 'static',
                keyboard:  false,
                focus: true
            },
            property_types,
            listing_types,
            price_sale,
            auth,
            isproject
        };
        const functions = {
            show : {
                function: async () => {
                    if(isTesting) console.log("generando recaptcha...");
                    const { generate } = recaptcha();
                    await generate();
                }
            },
            shown: {
                function : () => {
                    let location_approved = ["listings.custom", "projects.search"];
                    if(location_approved.includes(routename)){
                        let propertiesSelected = null;
                        if(type == "listing"){
                            propertiesSelected = {
                                listing_type: parameterFilterBase.listing_type ?? null,
                                property_type : parameterFilterBase.property_type ?? null,
                                district : parameterFilterBase.location.district ? (parameterFilterBase.location.district) : (parameterFilterBase.location.address ?? null),
                                price_end : parameterFilterBase.price_end ? `${parameterFilterBase.price_end.toLocaleString('en-US', {
                                    style:"currency",
                                    currency: 'USD',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0,
                                })}` : null,
                                price_start: parameterFilterBase.price_start ? `${parameterFilterBase.price_start.toLocaleString('en-US', {
                                    style:"currency",
                                    currency: 'USD',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0,
                                })}`: null
                            }

                        }else{
                            propertiesSelected = {
                                listing_type: parameterFilterBase.stage ?? null,
                                property_type : parameterFilterBase.project_type ? (parameterFilterBase.project_type == "office" ? 'officess' : parameterFilterBase.project_type) :  null,
                                district : parameterFilterBase.location.district ? (parameterFilterBase.location.district) : (parameterFilterBase.location.address ?? null),
                                price_end : parameterFilterBase.price_to ? `${parameterFilterBase.price_to.toLocaleString('en', {
                                    style:"currency",
                                    currency: 'USD',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0,
                                })}` : null,
                                price_start: parameterFilterBase.price_from ? `${parameterFilterBase.price_from.toLocaleString('en', {
                                    style:"currency",
                                    currency: 'USD',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0,
                                })}`: null
                            }

                            let currency = localStorage.getItem('dbcurrencyProject');
                            if(currency == 0){
                                propertiesSelected.price_start =  propertiesSelected.price_start.replace("$", "S/. ");
                                propertiesSelected.price_end =  propertiesSelected.price_end.replace("$", "S/. ");
                            }
                        }
                        $(`ul[data-id='listing_types'] li[data-code='${propertiesSelected.listing_type}']`).click();
                        $(`ul[data-id='property_types'] li[data-code='${propertiesSelected.property_type}']`).click();
                        $(`ul[data-id='price_start'] li[data-code='${propertiesSelected.price_start}']`).click();
                        $(`ul[data-id='price_end'] li[data-code='${propertiesSelected.price_end}']`).click(); 
                        $(".modal-alert #modaltagdistritos").setAction("val", propertiesSelected.district);
                    }
                }
            },
            hide : {
                function : () => {
                    removeCookie('redirect');
                }
            }

        }
        let formAlerta = {};
        let districtsArray = [];
        const actions = {
            initdropdown: () => {
                $(".modal-alert .dropdown-menu li").unbind("click");
                $(".modal-alert .dropdown-menu li").on("click", async function(){
                    const parent = $(this).parent().parent();
                    const id = parent.attr("data-id");
                    const name = $(this).attr("data-name");
                    const code = $(this).attr("data-code");
                    if( code === $("#" + id).val()){
                        return false;
                    }
                    $("#" + id + "_title").html(name);
                    $("#" + id).val(code).change();
                    $("#" + id).parent().removeClass("invalidate");
                });
            },
            step1: async () => {
                $(".btn-action").on("click", async function(){
                    if (!formValidate("#listing_types")
                        ||  !formValidate("#property_types")
                        ||  !formValidate("#lbldistricts")
                        ||  !formValidate("#price_start")
                        ||  !formValidate("#price_end")) return false;

                    let lbllistingtype = document.getElementById("listing_types");
                    let lblpropertytype = document.getElementById("property_types");
                    let lbldistricts = document.getElementById("lbldistricts");
                    let lblpricestart = document.getElementById("price_start");
                    let lblpriceend = document.getElementById("price_end");
                    let lblagent =  document.querySelector('#lblagent:checked');
                    if(lbldistricts.value != '') {
                        let array = JSON.parse(lbldistricts.value)
                        districtsArray = array.map((district)=>({
                            department: district.tag_departamento,
                            province: district.tag_provincia,
                            district: district.tag_distrito
                        }))
                    }
                    if( type == "listing" ){
                        formAlerta.listing_type = lbllistingtype.value;
                        formAlerta.property_type = lblpropertytype.value;
                    }else{
                        formAlerta.stage = lbllistingtype.value;
                        formAlerta.project_type = lblpropertytype.value;
                        formAlerta.currency = ( currency == 0 ) ? 'pen' : 'usd';
                    }
                    formAlerta.districts = districtsArray;
                    formAlerta.price_start = parseInt(lblpricestart.value.replace("$","").replace("S/. ","").replace(" ","").replace(/,/g, ''));
                    formAlerta.price_end = parseInt(lblpriceend.value.replace("$","").replace("S/. ","").replace(" ","").replace(/,/g, ''));
                    formAlerta.agent = (lblagent && lblagent.value == 'on') ? true : false;

                    dataTemp = {
                        url : getUrlClear(),
                        type : 'lviewalert',
                        data : formAlerta
                    };

                    setCookie("redirect", JSON.stringify(dataTemp), null, 3);

                    const auth = $(this).attr('data-auth');

                    if( auth === "true" ){
                        try {
                            await process();
                            await generate();
                            let viewlead = 'alert';
                            let profile = readdb("Profile");
                            let full_name = profile.data.data.full_name;
                            let email = profile.data.data.email;
                            let phone_number = profile.data.data.phone_number;
                            let prefix = profile.data.data.prefix !="" ? profile.data.data.prefix : '51';
                            $(".modal.show").modal("hide");
                            stepper.destroy();
                            const respuesta = await sendLead({
                                key: viewlead,
                                
                                ...formAlerta,

                                full_name: full_name,
                                email: email,
                                phone_number: phone_number,
                                prefix,
                                type:'alert',
                                disableSuccess: true
                            });
                            removeCookie('redirect');
                            if(respuesta.status == 200) alertShort('success', respuesta.data.data.message);
                        } catch (error) {
                            if(isTesting) console.log(error);
                            return checkErrorService(error.response);
                        }
                    }else{
                        const structure = { 
                            path: 'alertStepper', 
                            type: 'step2', 
                            alertType: ( isproject ) ? 'proyectos' : 'inmuebles',
                            googleloginurl,
                            URL_INFORMATION_TERMS_CONDITIONS,
                            URL_INFORMATION_PRIVACY,
                        }
                        await stepper.change(structure);
                        actions.step2();
                        loadPrefix({ idphone: "#lblphone", generate: true });
                    }
                });
                $(".modal-alert #modaltagdistritos").inputTagSelector({
                    type: 'fetch',
                    id:'lbldistricts',
                    filtro: async (buscar)=>{
                        const response = await searchDistrict(buscar);
                        const records = response.data.data;
                        return records.map(({ department,province,district})=>
                            ({ id:(`${department}-${province}-${district}`).replace(' ',''),
                            nombdep:department,
                            nombdist:district,
                            nombprov:province,
                            nomcompleto : `${district}, ${province}, ${department}`  })
                        );
                    },
                    ruta: 'https://bogota-laburbano.opendatasoft.com/api/records/1.0/search/?dataset=distritos-peru&facet=nombdep&facet=nombprov&q='
                });
                $("#listing_types").on("change", async () => {
                    if( type == "project" ) {
                        return;
                    }
                    $("#price_start_menu div").html('');
                    $("#price_end_menu div").html('');
                    $('#price_start option:not(:first)').remove();
                    $('#price_end option:not(:first)').remove();
                    $("#price_start_title").html('Desde');
                    $("#price_end_title").html('Hasta');
                    if( $("#listing_types").val() === 'sale'){
                        price_sale.forEach(function (rowObjet) {
                            jQuery('<li>', {
                                "data-code": rowObjet,
                                "data-name": rowObjet,
                                "text": rowObjet
                            }).appendTo('#price_start_menu div, #price_end_menu div');
                            jQuery('<option>', {
                                "value": rowObjet,
                                "text": rowObjet
                            }).appendTo('#price_start, #price_end');
                        });
                    }
                    if( $("#listing_types").val() === 'rent'){
                        price_rent.forEach(function (rowObjet) {
                            jQuery('<li>', {
                                "data-code": rowObjet,
                                "data-name": rowObjet,
                                "text": rowObjet
                            }).appendTo('#price_start_menu div, #price_end_menu div');
                            jQuery('<option>', {
                                "value": rowObjet,
                                "text": rowObjet
                            }).appendTo('#price_start, #price_end');
                        });
                    }
                    actions.initdropdown();
                })
                $(document).on('change', '#price_start, #price_end', function () {
                    const identify = $(this).attr("id");
                    const start = $("#price_start").val();
                    const end = $("#price_end").val();
                    const price_start = Number(start.replace("$","").replace("S/. ","").replace(" ","").replace(/,/g, ''));
                    const price_end = Number(end.replace("$","").replace("S/. ","").replace(" ","").replace(/,/g, ''));
                    if( price_start > 0 && price_end > 0 && price_start > price_end ){
                        let selector = (identify == 'price_start') ? '#price_start' : '#price_end';
                        let text = (identify == 'price_start') ? 'Desde' : 'Hasta';
                        $(selector).val('');
                        $(selector + "_title").html(text);
                    }
                });
                actions.initdropdown();

                if(window.listing_type){
                    document.getElementById("listing_types").value = listing_type;
                    let name = $(`.modal-alert .dropdown-menu li[data-code='${listing_type}']`).attr("data-name");
                    $("#listing_types_title").html(name);                   
                }
                if(window.property_type){
                    document.getElementById("property_types").value = property_type;
                    let name = $(`.modal-alert .dropdown-menu li[data-code='${property_type}']`).attr("data-name");
                    $("#property_types_title").html(name);                   
                }
                if(window.district && typeof district != 'undefined'){

                    let item_district = district.toLowerCase();
                    let item_province = province.toLowerCase();
                    let item_department = department.toLowerCase();

                    const response = await searchDistrict(district);
                    let records = response.data.data;
                        records = records.map(({ department,province,district})=>
                            ({ tag_id:(`${department}-${province}-${district}`).replace(' ',''),
                            tag_departamento:department,
                            tag_distrito:district,
                            tag_provincia:province,
                            tag_fullname : `${district}, ${province}, ${department}`})
                        )
                        .filter(({tag_departamento, tag_distrito, tag_provincia})=> tag_departamento.toLowerCase() == item_department && tag_provincia.toLowerCase() == item_province && tag_distrito.toLowerCase() == item_district);

                        if(document.getElementById("lbldistricts")) document.getElementById("lbldistricts").value = JSON.stringify(records);
                        
                        if(records.length > 0){

                            let badgeElement = document.querySelector(".input-tags-container .badged-container");
                            let results = document.querySelector(".input-tags-container .dropdown-menu");
                            let selected = results.querySelector(".selected");

                            records.forEach(({tag_distrito = '', tag_id = ''}, i)=>{
                                let button = document.createElement("button");
                                    button.innerHTML = tag_distrito;
                                    button.classList.add("btn");
                                    button.classList.add("btn-primary");
                                    button.classList.add("me-1");
                                    button.setAttribute('data-id', tag_id);

                                    let identify = new Date().getTime()+i;
                                    button.setAttribute('close-identify',identify);

                                    selected.append(button);

                                let span1 = document.createElement("span")
                                    span1.classList.add("badged-only-selected");

                                let span2 = document.createElement("span");
                                    span2.innerHTML = tag_distrito;

                                    span1.append(span2);

                                    badgeElement.append(span1);
                            });

                            
                            results.classList.add("only-results");
                            
                            badgeElement.style.display = "flex";
                            results.style.display = "none";
                        }
                }
            },
            step2: () => {
                $(".btn-action").on("click", async function(){
                    if (!formValidate("#lblname")
                        ||  !formValidate("#lblemail")
                        ||  !formValidate("#lblphone")        
                        ||  !formValidate("#lblpassword")) return false;

                    const { phone, codeNumber } = getCodeNumberSelected();

                    const name = document.querySelector("#lblname").value;
                    const email = document.querySelector("#lblemail").value;
                    const telefono = phone;
                    const prefix = codeNumber;
                    const password = document.querySelector("#lblpassword").value;

                    try {
                        await process();
                        await generate();
                        let viewlead = 'alert';
                        $(".modal.show").modal("hide");
                        stepper.destroy();
                        const respuesta = await sendLead({
                            key: viewlead,

                            ...formAlerta,

                            full_name: name,
                            email,
                            phone_number: telefono,
                            password,
                            prefix,
                            type:'alert',
                            disableSuccess: true
                        });
                        if(respuesta.status == 200) alertShort('success', respuesta.data.data.message);

                    } catch (error) {        
                        if(isTesting) console.log(error);
                    }
                });
                $(".btn-back").on("click", async function(){
                    removeCookie('redirect');
                    const structure = { 
                        path: 'alertStepper', 
                        type: 'step1',
                        property_types,
                        listing_types,
                        price_sale,
                        auth,
                        babilonia_label_default
                    }
                    await stepper.change(structure);
                    actions.step1();
                });
                $(".btn-social.facebook").on("click", function(){
                    setCookie("redirect", JSON.stringify({...dataTemp, sip: 'facebook'}), null, 3);                    
                    fbLogin();
                });
                $(".btn-social.google[data-login-url]").on("click", function(element){
                    setCookie("redirect", JSON.stringify({...dataTemp, sip: 'google'}), null, 3);
                    let url = this.getAttribute("data-login-url");
                    window.location = url;
                })
            }
        };
        const stepper = new ModalStepper()
        await stepper.create( structure, functions );
        actions.step1();
        return stepper;
    }
    #getTemplate = async (path) => {
        const response = await fetch(`/assets/templates/${path}`)
        const texto = await response.text();
        return texto;
    }
    create = async ( structure = {}, functions = {} ) => {
        if(!this.modalWrap){
            const path = structure.path? structure.path + '/':'';
            const type = structure.type??'modal';
            const component = await this.getTemplate(`/modal/${path}${type}.hbs`)
            this.identity = Math.random().toString(36).slice(2, 7);
            this.modalWrap = document.createElement('div');
            structure.identity = this.identity;
            const template = Handlebars.compile(component);
            
            if(type === 'index'){
                const step = await this.getTemplate(`/modal/${path}step1.hbs`);
                Handlebars.registerPartial('step', step);
            }
            const html = template(structure);
            this.modalWrap.innerHTML = html;
            document.body.append(this.modalWrap);
            const selector = this.modalWrap.querySelector('.modal');
            const modal = new bootstrap.Modal(selector, structure.options);
            const btnsuccess = selector.querySelector('.modal-success-btn');
            const btnCancel = selector.querySelector('.modal-cancel-btn');
            if( btnsuccess ){
                btnsuccess.onclick = async function(){
                    if(functions.success?.close??true){
                        $(selector).modal('hide');
                    }
                    if (functions.hasOwnProperty('success')){
                        let loaderWrap
                        if(functions.success.loader??false){
                            loaderWrap = await Loader.create();
                        }
                        if ( typeof functions.success.function == 'function' ) { 
                            try {
                                await functions.success.function(); 
                                if( loaderWrap ){ loaderWrap.remove(); }
                            } catch (error) {
                                console.log(error);
                                if( loaderWrap ){ loaderWrap.remove(); }
                            }
                        }
                    }
                };
            }
            if( btnCancel ){
                btnCancel.onclick = async function(){
                    if(functions.cancel?.close??true){
                        $(selector).modal('hide');
                    }
                    if (functions.hasOwnProperty('cancel')){
                        let loaderWrap
                        if(functions.cancel.loader??false){
                            loaderWrap = await Loader.create();
                        }
                        if ( typeof functions.cancel.function == 'function' ) { 
                            try {
                                await functions.cancel.function(); 
                                if( loaderWrap ){ loaderWrap.remove(); }
                            } catch (error) {
                                console.log(error);
                                if( loaderWrap ){ loaderWrap.remove(); }
                            }
                        }
                    }   
                };
            }
            selector.addEventListener('show.bs.modal', async event => {
                if (functions.hasOwnProperty('show')){
                    let loaderWrap
                    if(functions.show.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.show.function == 'function' ) { 
                        try {
                            await functions.show.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            selector.addEventListener('shown.bs.modal', async event => {
                if (functions.hasOwnProperty('shown')){
                    let loaderWrap
                    if(functions.shown.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.shown.function == 'function' ) { 
                        try {
                            await functions.shown.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            selector.addEventListener('hide.bs.modal', async event => {
                if (functions.hasOwnProperty('hide')){
                    let loaderWrap
                    if(functions.hide.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.hide.function == 'function' ) { 
                        try {
                            await functions.hide.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            selector.addEventListener('hidden.bs.modal', async event => {
                if( this.remove ){
                    $(this.modalWrap).remove();
                    this.modalWrap = null;
                }
                if (functions.hasOwnProperty('hidden')){
                    let loaderWrap
                    if(functions.hidden.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.hidden.function == 'function' ) { 
                        try {
                            await functions.hidden.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            modal.show();
        }else{
            console.log("modal ya creado.");
        }
    }
    show = () => {
        if(this.modalWrap){
            this.remove = true;
            $(this.modalWrap).find(".modal").modal('show');
        }else{
            console.log("Debe incializar el modal para poder usar este metodo.");
        }
    }
    hide = () => {
        this.remove = false;
        if( this.modalWrap ) $(this.modalWrap).find(".modal").modal('hide');
    }
    destroy = () => {
        if( this.modalWrap ) $(this.modalWrap).remove();
        $(".modal-backdrop").remove();
        $("body").removeAttr("style");
        this.modalWrap = null;
    }
    change = async ( structure = {}, functions = {} ) => {
        if( this.modalWrap ){
            const path = structure.path? structure.path + '/':'';
            const type = structure.type??'modal';
            const component = await this.getTemplate(`/modal/${path}${type}.hbs`)
            const template = Handlebars.compile(component);
            if(type == "step2"){
                const inputcountrypicker = await getComponent({
                    url:'/component-countrypicker'
                });
                structure["inputcountrypicker"] = inputcountrypicker;
            }
            const html = template(structure);
            $( "#" + this.identity + " .modal-dialog" ).html(html);
            this.setFunctions(functions);
        }else{
            console.log("no puedes modificar el contenido del modal sin haberlo inicializado.");
        }
    }
    setFunctions = async ( functions = {} ) => {
        if( this.modalWrap ){
            this.functions = functions;
            const selector = this.modalWrap.querySelector('.modal');
            const btnsuccess = selector.querySelector('.modal-success-btn');
            const btnCancel = selector.querySelector('.modal-cancel-btn');
            if( btnsuccess ){
                $(btnsuccess).unbind( 'click' );
                btnsuccess.onclick = async function(){
                    if(functions.success?.close??true){
                        $(selector).modal('hide');
                    }
                    if (functions.hasOwnProperty('success')){
                        let loaderWrap
                        if(functions.success.loader??false){
                            loaderWrap = await Loader.create();
                        }
                        if ( typeof functions.success.function == 'function' ) { 
                            try {
                                await functions.success.function(); 
                                if( loaderWrap ){ loaderWrap.remove(); }
                            } catch (error) {
                                console.log(error);
                                if( loaderWrap ){ loaderWrap.remove(); }
                            }
                        }
                    }
                };
            }
            if( btnCancel ){
                $(btnCancel).unbind( 'click' );
                btnCancel.onclick = async function(){
                    if(functions.cancel?.close??true){
                        $(selector).modal('hide');
                    }
                    if (functions.hasOwnProperty('cancel')){
                        let loaderWrap
                        if(functions.cancel.loader??false){
                            loaderWrap = await Loader.create();
                        }
                        if ( typeof functions.cancel.function == 'function' ) { 
                            try {
                                await functions.cancel.function(); 
                                if( loaderWrap ){ loaderWrap.remove(); }
                            } catch (error) {
                                console.log(error);
                                if( loaderWrap ){ loaderWrap.remove(); }
                            }
                        }
                    }   
                };
            }
            selector.addEventListener('show.bs.modal', async event => {
                if (functions.hasOwnProperty('show')){
                    let loaderWrap
                    if(functions.show.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.show.function == 'function' ) { 
                        try {
                            await functions.show.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            selector.addEventListener('shown.bs.modal', async event => {
                if (functions.hasOwnProperty('shown')){
                    let loaderWrap
                    if(functions.shown.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.shown.function == 'function' ) { 
                        try {
                            await functions.shown.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            selector.addEventListener('hide.bs.modal', async event => {
                if (functions.hasOwnProperty('hide')){
                    let loaderWrap
                    if(functions.hide.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.hide.function == 'function' ) { 
                        try {
                            await functions.hide.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            selector.addEventListener('hidden.bs.modal', async event => {
                if( this.remove ){
                    $(this.modalWrap).remove();
                    this.modalWrap = null;
                }
                if (functions.hasOwnProperty('hidden')){
                    let loaderWrap
                    if(functions.hidden.loader??false){
                        loaderWrap = await Loader.create();
                    }
                    if ( typeof functions.hidden.function == 'function' ) { 
                        try {
                            await functions.hidden.function(); 
                            if( loaderWrap ){ loaderWrap.remove(); }
                        } catch (error) {
                            console.log(error);
                            if( loaderWrap ){ loaderWrap.remove(); }
                        }
                    }
                }  
            })
            $(selector).modal("show");
        }
    }
    close = () => {
        const selector = this.modalWrap.querySelector('.modal');
        $(selector).modal('hide');
    }
}
export class Loader {
    #loaderWrap;
    constructor(div = null) {
        this.create(div);
    }
    #create = async (div = null) => {
        return new Promise(async (resolve) => {
            this.loaderWrap = document.createElement('div');            
            const component = await fetch(`/assets/templates/modal/loader.hbs`)
            const texto = await component.text();
            const template = Handlebars.compile(texto);
            const identity = Math.random().toString(36).slice(2, 7);
            const html = template({identity});
            if(this.loaderWrap){
                this.loaderWrap.innerHTML = html;                
                if(div){
                    div.append(this.loaderWrap);
                    $(this.loaderWrap).addClass("container-loader");
                }else{
                    document.body.append(this.loaderWrap);
                }
                $("body").css("overflow", "hidden");
            }
            resolve(true);
        });
    }
    destroy = () => {
        $("body").css("overflow", "auto");
        $(this.loaderWrap).remove();
        this.loaderWrap = null;
    }
}
export const Croppie = {
    create: async ( structure = {} ) => {
        return new Promise(async (resolve) => {
            let modalWrap = document.createElement('div');
            const component = await fetch(`/assets/templates/modal/croppie.hbs`)
            const texto = await component.text();
            const template = Handlebars.compile(texto);
            const html = template();
            modalWrap.innerHTML = html;
            document.body.append(modalWrap);
            const selector = modalWrap.querySelector('.modal');
            const modal = new bootstrap.Modal(selector);
            $(selector).on('shown.bs.modal', event => {
                $(selector).find("#croppie").croppie({
                    enableExif: true,
                    enableResize: false,
                    enableZoom: true,
                    viewport: {
                        width: structure.width??250,
                        height: structure.height??250,
                        type: structure.mode??'circle'
                    },
                    boundary: {
                        width: 450,
                        height: 450
                    },
                    url: structure.url??null
                });        
            })
            selector.addEventListener('hidden.bs.modal', async event => {
                $(modalWrap).remove();
            })
            modal.show();
            resolve($(modalWrap));
        });
    }
}
export class OneTap {
    constructor() {
        this.create();
    }
    #create = async () => {
        if( $("#one-tap-popup").length ){
            if(isTesting) console.log("One tap ya creado.");
        }else{
            const component = await fetch(`/assets/templates/modal/onetap.hbs`)
            const identity = Math.random().toString(36).slice(2, 7);
            const texto = await component.text();
            const template = Handlebars.compile(texto);
            const html = template({ identity, googleloginurl });
            const modalWrap = document.createElement('div');
            modalWrap.classList.add("one-tap-popup");
            modalWrap.innerHTML = html;
            document.body.append(modalWrap);
            modalWrap.classList.add("close-one-tap-animation");
            modalWrap.style.display = "flex";
            setTimeout(() => {
                modalWrap.classList.remove("close-one-tap-animation")
            }, 50);
            $("#one-tap-popup .btnfacebook").click(function(){
                fbLogin();
            });
            $("#one-tap-popup [data-login-url]").click(function(element){
                let url = this.getAttribute("data-login-url");
                window.location = url;
            })
            $("#one-tap-popup .close-popup").click(function(){
                modalWrap.classList.add("close-one-tap-animation");
                setTimeout(() => {
                    $(modalWrap).remove();
                }, 1000);
            });
        }
    }
}
