const q=(s,c=document)=>c.querySelector(s),qa=(s,c=document)=>[...c.querySelectorAll(s)];
const panel=q('.mobile-panel'),back=q('.panel-backdrop'),toggle=q('.menu-toggle');
function menu(open){panel?.classList.toggle('open',open);back?.classList.toggle('open',open);document.body.classList.toggle('lock',open);toggle?.setAttribute('aria-expanded',String(open));panel?.setAttribute('aria-hidden',String(!open))}
toggle?.addEventListener('click',()=>menu(true));q('.panel-close')?.addEventListener('click',()=>menu(false));back?.addEventListener('click',()=>menu(false));
addEventListener('scroll',()=>{const h=document.documentElement,p=q('#progress');if(p)p.style.width=((h.scrollHeight-h.clientHeight)>0?h.scrollTop/(h.scrollHeight-h.clientHeight)*100:0)+'%'});
qa('form[data-lead-form]').forEach(form=>form.addEventListener('submit',async e=>{e.preventDefault();const note=q('.notice',form),btn=q('button[type=submit]',form),original=btn.textContent;btn.disabled=true;btn.textContent='Sending…';try{const endpoint=window.MIDCITY?.leadEndpoint||'api/lead.php';const r=await fetch(endpoint,{method:'POST',body:new FormData(form),headers:{'X-Requested-With':'XMLHttpRequest'}});const j=await r.json();note.className='notice '+(j.ok?'ok':'err');note.textContent=j.message;if(j.ok)form.reset()}catch(x){note.className='notice err';note.textContent='Unable to send right now. Please call us directly.'}finally{btn.disabled=false;btn.textContent=original}}));
qa('[data-wizard-form]').forEach(form=>{
  const steps=qa('.wizard-step',form),nodes=qa('.wizard-node',form); let current=0;
  const show=i=>{current=Math.max(0,Math.min(i,steps.length-1));steps.forEach((s,n)=>s.classList.toggle('active',n===current));nodes.forEach((n,x)=>{n.classList.toggle('active',x===current);n.classList.toggle('done',x<current)});form.scrollIntoView({behavior:'smooth',block:'center'})};
  const valid=()=>{const fields=qa('input[required],textarea[required],select[required]',steps[current]);for(const f of fields){if(!f.checkValidity()){f.reportValidity();return false}}return true};
  qa('.wizard-next',form).forEach(b=>b.addEventListener('click',()=>{if(valid())show(current+1)}));
  qa('.wizard-prev',form).forEach(b=>b.addEventListener('click',()=>show(current-1)));
});
