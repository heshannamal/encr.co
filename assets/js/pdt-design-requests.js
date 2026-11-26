(() => {
    const newRequest=document.getElementById('pdtNewRequest');
    document.querySelector('[data-open-request]')?.addEventListener('click',()=>newRequest.showModal());
    document.querySelectorAll('[data-close-dialog]').forEach(button=>button.addEventListener('click',()=>button.closest('dialog').close()));
    if(newRequest){
        const organization=newRequest.querySelector('[data-request-organization]');
        if(organization && window.jQuery?.fn?.select2){window.jQuery(organization).select2({dropdownParent:window.jQuery(newRequest),width:'100%',placeholder:'Without organization',allowClear:true});}

        const options=[...newRequest.querySelectorAll('[data-product-option]')];
        const count=()=>{newRequest.querySelector('[data-product-count]').textContent=`${newRequest.querySelectorAll('[name="products[]"]:checked').length} products selected`;};
        newRequest.querySelector('[data-product-search]').addEventListener('input',event=>options.forEach(label=>{label.hidden=!label.textContent.toLowerCase().includes(event.target.value.toLowerCase());}));
        newRequest.addEventListener('change',count);count();
        newRequest.querySelector('form').addEventListener('submit',event=>{
            if(!newRequest.querySelector('[name="products[]"]:checked')){event.preventDefault();newRequest.querySelector('[data-product-count]').textContent='Please choose at least one product.';return;}
            const button=newRequest.querySelector('[type=submit]');button.disabled=true;button.textContent='Sending…';
        });
    }
    function toggleRequest(id){
        const detail=document.getElementById(id);if(!detail)return;
        detail.hidden=!detail.hidden;
        document.querySelectorAll('[data-expand-request],[data-toggle-request]').forEach(control=>{
            if((control.dataset.expandRequest||control.dataset.toggleRequest)===id)control.setAttribute('aria-expanded',String(!detail.hidden));
        });
    }
    document.querySelectorAll('[data-expand-request]').forEach(row=>{
        row.addEventListener('click',event=>{if(!event.target.closest('a,button,input,select') && !window.getSelection()?.toString())toggleRequest(row.dataset.expandRequest);});
        row.addEventListener('keydown',event=>{if(event.target===row && (event.key==='Enter'||event.key===' ')){event.preventDefault();toggleRequest(row.dataset.expandRequest);}});
    });
    document.querySelectorAll('[data-toggle-request]').forEach(button=>button.addEventListener('click',()=>toggleRequest(button.dataset.toggleRequest)));
    const preview=document.getElementById('pdtImagePreview');
    document.querySelectorAll('[data-preview-image]').forEach(button=>button.addEventListener('click',()=>{
        const img=preview.querySelector('[data-preview-full]');img.src=button.dataset.previewImage;img.alt=button.dataset.previewTitle;
        preview.querySelector('h2').textContent=button.dataset.previewTitle;preview.showModal();
    }));
    document.querySelectorAll('[data-copy-design]').forEach(button=>button.addEventListener('click',async()=>{
        try{
            if(navigator.clipboard && window.isSecureContext)await navigator.clipboard.writeText(button.dataset.copyDesign);
            else {const field=document.createElement('textarea');field.value=button.dataset.copyDesign;field.style.position='fixed';field.style.opacity='0';document.body.append(field);field.select();const copied=document.execCommand('copy');field.remove();if(!copied)throw new Error('Copy failed');}
            button.textContent='Copied!';setTimeout(()=>button.textContent='Copy link',2000);
        }catch(error){button.textContent='Retry copy';}
    }));
    const modal=document.getElementById('pdtDesignPicker');if(!modal)return;
    const grid=modal.querySelector('[data-picker-grid]'),error=modal.querySelector('[data-picker-error]'),add=modal.querySelector('[data-add-designs]'),more=modal.querySelector('[data-load-more]');
    let gallery='',destination='',next=null,chosen=new Set(),busy=false,sequence=0;
    const count=()=>{modal.querySelector('[data-picked-count]').textContent=`${chosen.size} selected`;add.disabled=busy || !chosen.size;};
    const message=value=>{error.textContent=value;error.hidden=!value;};
    async function load(url,append=false){
        const request=++sequence;busy=true;count();more.disabled=true;message('');
        if(!append){grid.replaceChildren();next=null;more.hidden=true;}
        try{
            const response=await fetch(url,{headers:{Accept:'application/json'},credentials:'same-origin'});
            const result=await response.json();if(!response.ok)throw new Error(result.message || 'Designs could not be loaded.');
            if(request!==sequence)return;
            if(!result.designs.length && !append){const empty=document.createElement('p');empty.className='pdt-picker-empty';empty.textContent='No saved designs found for this product. Create and save a design in PDT, then search again.';grid.append(empty);}
            result.designs.forEach(design=>{
                const label=document.createElement('label');label.className='pdt-picker-choice';
                const check=document.createElement('input');check.type='checkbox';check.value=design.id;check.disabled=design.selected;check.checked=design.selected || chosen.has(design.id);
                const image=document.createElement('img');image.src=design.preview_url;image.alt=design.name;image.loading='lazy';
                const name=document.createElement('strong');name.textContent=design.name;
                const state=document.createElement('span');state.className='pdt-picker-state';state.textContent=design.selected?'Already added':check.checked?'Selected':'Click to select';
                label.append(check,image,name,state);
                if(design.selected){const badge=document.createElement('small');badge.textContent='Already added';label.append(badge);}
                check.addEventListener('change',()=>{if(check.checked)chosen.add(design.id);else chosen.delete(design.id);state.textContent=check.checked?'Selected':'Click to select';count();});
                grid.append(label);
            });
            next=result.next;more.hidden=!next;
        }catch(failure){if(request===sequence)message(failure.message || 'Could not load designs. Please retry.');}
        finally{if(request===sequence){busy=false;more.disabled=false;count();}}
    }
    document.querySelectorAll('[data-design-picker]').forEach(button=>button.addEventListener('click',()=>{
        gallery=button.dataset.gallery;destination=button.dataset.addUrl;chosen=new Set();
        modal.querySelector('[data-picker-product]').textContent=button.dataset.productName;
        modal.querySelector('[data-open-designer]').href=button.dataset.designerUrl;
        modal.querySelector('[data-design-search]').reset();more.hidden=true;modal.showModal();load(gallery);
    }));
    modal.querySelector('[data-design-search]').addEventListener('submit',event=>{event.preventDefault();const url=new URL(gallery,location.href);url.searchParams.set('search',new FormData(event.target).get('search') || '');load(url);});
    more.addEventListener('click',()=>{if(next&&!busy)load(next,true);});
    add.addEventListener('click',async()=>{
        if(busy||!chosen.size)return;busy=true;count();message('');add.textContent='Adding…';
        try{
            const response=await fetch(destination,{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json',Accept:'application/json','X-CSRF-TOKEN':modal.dataset.csrf},body:JSON.stringify({templates:[...chosen]})});
            const result=await response.json();if(!response.ok)throw new Error(result.message || 'Designs could not be added.');
            location.reload();
        }catch(failure){message(failure.message || 'Could not add designs. Please retry.');busy=false;count();add.textContent='Add selected designs';}
    });
})();
