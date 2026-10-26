// Shrinks big phone photos in the browser before upload so they never hit the server size limit.
document.addEventListener('change',e=>{const i=e.target;if(i.type!=='file'||!(i.accept||'').includes('image'))return;const f=i.files[0];
if(!f||!f.type.startsWith('image/')||f.size<500000)return;const img=new Image();
img.onload=()=>{const s=Math.min(1,1400/Math.max(img.width,img.height)),c=document.createElement('canvas');c.width=img.width*s;c.height=img.height*s;c.getContext('2d').drawImage(img,0,0,c.width,c.height);
c.toBlob(b=>{if(!b)return;const d=new DataTransfer();d.items.add(new File([b],'photo.jpg',{type:'image/jpeg'}));i.files=d.files},'image/jpeg',.85);URL.revokeObjectURL(img.src)};img.src=URL.createObjectURL(f)});
