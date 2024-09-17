<?php

	function list_SO_count_report1()
	{
	  $valor_devuelto= "select distinct so.idsaleorders,so_soft_external,count(distinct ciu) as cciu, count(distinct so.idsaleorders) as cc ,REPLACE(namecustomers,',','#') ,so.datesoapproved1  from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders where namecustomers is not null and so_soft_external is not null and so_soft_external like '%SO' and  so.datesoapproved1  between current_date30 and now() group by so.idsaleorders,so_soft_external,namecustomers having count(distinct ciu) >0 order by so_soft_external desc ";
	  $valor_devuelto= "select distinct so.idsaleorders,so_soft_external,count(distinct ciu) as cciu, count(distinct so.idsaleorders) as cc ,REPLACE(namecustomers,',','#') ,so.datesoapproved1  from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders where namecustomers is not null and so_soft_external is not null and so_soft_external like '%SO' group by so.idsaleorders,so_soft_external,namecustomers having count(distinct ciu) >0 order by so_soft_external desc ";
	  $valor_devuelto= "select distinct so.idsaleorders,so_soft_external,count(distinct ciu) as cciu, count(distinct so.idsaleorders) as cc ,REPLACE(namecustomers,',','#') ,so.datesoapproved1 
,agrupadoresxidsaleorders.groupxciu, agrupadoresxidsaleorders.groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
inner join ( 
select so.idsaleorders , array_agg(coalesce(ciu,'')) as groupxciu,  array_agg(coalesce(sn_unit,'')) as groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
group by so.idsaleorders
) as agrupadoresxidsaleorders
on agrupadoresxidsaleorders.idsaleorders = so.idsaleorders
where namecustomers is not null and so_soft_external is not null and so_soft_external like '%SO' 
group by so.idsaleorders,so_soft_external,namecustomers ,agrupadoresxidsaleorders.groupxciu, agrupadoresxidsaleorders.groupxsn ,so.datesoapproved1
having count(distinct ciu) >0 order by so_soft_external desc";
////version mejorada con totales.
$valor_devuelto ="select *
from ( 
select distinct so.idsaleorders,so_soft_external,count(distinct so_sp.ciu) as cciu, count(distinct so.idsaleorders) as cc ,
REPLACE(namecustomers,',','#') ,so.datesoapproved1 ,agrupadoresxidsaleorders.groupxciu, agrupadoresxidsaleorders.groupxsn
from saleorders so
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
inner join ( select so.idsaleorders , array_agg(coalesce(ciu,'')) as groupxciu, array_agg(coalesce(sn_unit,'')) as groupxsn 
			from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders group by so.idsaleorders 
		   ) as agrupadoresxidsaleorders
on agrupadoresxidsaleorders.idsaleorders = so.idsaleorders 



where namecustomers is not null and so_soft_external is not null and so_soft_external like '%SO' group by so.idsaleorders,so_soft_external,namecustomers ,
agrupadoresxidsaleorders.groupxciu, agrupadoresxidsaleorders.groupxsn ,so.datesoapproved1 having count(distinct so_sp.ciu) >0 order by so_soft_external desc
) as  list_so

left join
( select so_sp.idsaleorders, count(distinct digm.sn_unit)  as cantdib from  saleorders_specs so_sp 
  left join digmodule digm on digm.sn_unit = so_sp.sn_unit and digm.ciu_unit = so_sp.ciu  
	and digm.band = so_sp.idband  
    group by  so_sp.idsaleorders
) as so_conmodulos  on list_so.idsaleorders = so_conmodulos.idsaleorders

left join
( select so_sp.idsaleorders, count(distinct calibfchk.sn_unit)  as cantcalib from  saleorders_specs so_sp 
  left join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 0
    group by  so_sp.idsaleorders
) as so_concalibrat  on list_so.idsaleorders = so_concalibrat.idsaleorders
left join
( select so_sp.idsaleorders, count(distinct calibfchk.sn_unit)  as cantfinalchk from  saleorders_specs so_sp 
  left join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 1
    group by  so_sp.idsaleorders
) as so_concalibratfinalchk  on list_so.idsaleorders = so_concalibratfinalchk.idsaleorders";




	  return $valor_devuelto;
	}

	function list_SO_count_report1_RMA()
	{
	  $valor_devuelto= "select distinct so.idsaleorders,so_soft_external,count(distinct ciu) as cciu, count(distinct so.idsaleorders) as cc ,REPLACE(namecustomers,',','#') ,so.datesoapproved1  from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders where namecustomers is not null and so_soft_external is not null and so_soft_external like '%RM' group by so.idsaleorders,so_soft_external,namecustomers having count(distinct ciu) >0 order by so_soft_external desc";
	   $valor_devuelto= "select distinct so.idsaleorders,so_soft_external,count(distinct ciu) as cciu, count(distinct so.idsaleorders) as cc ,REPLACE(namecustomers,',','#') ,so.datesoapproved1 
,agrupadoresxidsaleorders.groupxciu, agrupadoresxidsaleorders.groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
inner join ( 
select so.idsaleorders , array_agg(coalesce(ciu,'')) as groupxciu,  array_agg(coalesce(sn_unit,'')) as groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
group by so.idsaleorders
) as agrupadoresxidsaleorders
on agrupadoresxidsaleorders.idsaleorders = so.idsaleorders
where namecustomers is not null and so_soft_external is not null and so_soft_external like '%RM'
group by so.idsaleorders,so_soft_external,namecustomers ,agrupadoresxidsaleorders.groupxciu, agrupadoresxidsaleorders.groupxsn,so.datesoapproved1
having count(distinct ciu) >0 order by so_soft_external desc";
	  return $valor_devuelto;
	}
	
	
	
	function list_show_CIU_by_SO($v_idsaleordersBD)
	{
	  $valor_devuelto= "select distinct  ciu,case when ifdualband=0 then 1 when ifdualband=1 then 1 else ifdualband end  as ifdualband2, count(distinct coalesce( sn_unit,'0')) as cc_sn from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders where so.idsaleorders = ".$v_idsaleordersBD." group by ciu,ifdualband ";
	  $valor_devuelto= "select distinct  so_sp.ciu,
case when ifdualband=0 then 1 when ifdualband=1 then 1 else ifdualband end  as ifdualband2, 
count(distinct coalesce( sn_unit,'0')) as cc_sn , agrupadoresxidsaleorders.groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
left join ( 
select so.idsaleorders , so_sp.ciu,  array_agg(coalesce(sn_unit,'')) as groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
	where so.idsaleorders = ".$v_idsaleordersBD."
group by so.idsaleorders , so_sp.ciu
) as agrupadoresxidsaleorders
on agrupadoresxidsaleorders.idsaleorders = so.idsaleorders and
agrupadoresxidsaleorders.ciu = so_sp.ciu

where so.idsaleorders = ".$v_idsaleordersBD."
group by so_sp.ciu,ifdualband2 ,agrupadoresxidsaleorders.groupxsn";
/////vesion mejorada con totales.

	  $valor_devuelto= "select *
from ( 
select distinct   so_sp.ciu,
case when ifdualband=0 then 1 when ifdualband=1 then 1 else ifdualband end  as ifdualband2, 
count(distinct coalesce( sn_unit,'0')) as cc_sn , agrupadoresxidsaleorders.groupxsn,so.idsaleorders 
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
left join ( 
select so.idsaleorders , so_sp.ciu,  array_agg(coalesce(sn_unit,'')) as groupxsn
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
	where so.idsaleorders = ".$v_idsaleordersBD."
group by so.idsaleorders , so_sp.ciu
) as agrupadoresxidsaleorders
on agrupadoresxidsaleorders.idsaleorders = so.idsaleorders and
agrupadoresxidsaleorders.ciu = so_sp.ciu

where so.idsaleorders = ".$v_idsaleordersBD."
group by  so.idsaleorders ,so_sp.ciu,ifdualband2 ,agrupadoresxidsaleorders.groupxsn 
) as  list_so_cui

left join
( select so_sp.idsaleorders, so_sp.ciu, count(distinct digm.sn_unit)  as cantdib from  saleorders_specs so_sp 
  left join digmodule digm on digm.sn_unit = so_sp.sn_unit and digm.ciu_unit = so_sp.ciu  
	and digm.band = so_sp.idband  
    group by so_sp.idsaleorders, so_sp.ciu
) as so_conmodulos  on list_so_cui.idsaleorders = so_conmodulos.idsaleorders and
list_so_cui.ciu = so_conmodulos.ciu

left join
( select so_sp.idsaleorders, so_sp.ciu, count(distinct 	calibfchk.sn_unit)  as cantcalib from  saleorders_specs so_sp 
  left join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 0
    group by so_sp.idsaleorders, so_sp.ciu
) as so_concalibrat  on list_so_cui.idsaleorders = so_concalibrat.idsaleorders and
list_so_cui.ciu = so_concalibrat.ciu
left join
( select so_sp.idsaleorders, so_sp.ciu,  count(distinct calibfchk.sn_unit)  as cantfinalchk from  saleorders_specs so_sp 
  left join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 1
    group by  so_sp.idsaleorders,so_sp.ciu
) as so_concalibratfinalchk  
on list_so_cui.idsaleorders = so_concalibratfinalchk.idsaleorders and
list_so_cui.ciu = so_concalibratfinalchk.ciu ";


	  return $valor_devuelto;
	}
	
	function list_show_CIU_SN($v_idsaleordersBD, $v_idciu)
	{
	  $valor_devuelto= "select distinct coalesce(  so_sp.sn_unit,' --') sn,case when ifdualband=0 then 1 when ifdualband=1 then 1 else ifdualband end  as ifdualband  from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders where so.idsaleorders = ".$v_idsaleordersBD." and ciu ='$v_idciu'";
	  return $valor_devuelto;
	}
	

	function list_show_SO_CIU_SN($v_idsaleordersBD, $v_idciu,$v_sn)
	{
	  $valor_devuelto= "select distinct coalesce(  so_sp.sn_unit,' --') sn, so_sp.idband,
	  maxdigm.sn_module, maxidit,countdigm ,digm2.totalpass as  totalpassdig
	from saleorders so 
	inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
	inner join 
	(
		
		select so.idsaleorders, so_sp.ciu, digm.sn_unit,coalesce(digm.sn_module,'') as sn_module,so_sp.idband,
		coalesce(count(distinct digm.idit),0) as countdigm,
		coalesce(max(digm.idit),0) as maxidit, coalesce(max(so_sp.idrev),0) as maxidrev
		from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
		inner join digmodule digm on digm.sn_unit = so_sp.sn_unit and digm.ciu_unit = so_sp.ciu  
		and digm.band = so_sp.idband 
		where so.idsaleorders = ".$v_idsaleordersBD." and so_sp.ciu ='$v_idciu' and digm.sn_unit ='$v_sn'
		group by so.idsaleorders, so_sp.ciu, digm.sn_unit , so_sp.idband,sn_module
		
		
	) as maxdigm	
	on maxdigm.sn_unit = so_sp.sn_unit and 
	   maxdigm.ciu = so_sp.ciu and
	   maxdigm.idsaleorders = so_sp.idsaleorders and
	   maxdigm.idband = so_sp.idband and
	   maxdigm.maxidrev   = so_sp.idrev
	inner join digmodule as digm2  
	on digm2.sn_unit = maxdigm.sn_unit 
	and digm2.ciu_unit = maxdigm.ciu  
	and digm2.idit = maxdigm.maxidit	
	and digm2.sn_module = maxdigm.sn_module 
	and digm2.band = maxdigm.idband 
	where so.idsaleorders = ".$v_idsaleordersBD." and so_sp.ciu ='$v_idciu'";
	  return $valor_devuelto;
	}
	
	function list_show_SO_CIU_SN_calib($v_idsaleordersBD, $v_idciu, $v_sn, $v_idband)
	{
	  $valor_devuelto= "select distinct coalesce(  so_sp.sn_unit,' --') sn, so_sp.idband,
	
	  maxcalif.sn_module as sn_modulecf, maxiditcalif,countdigmcalif ,calibfchk2.totalpass as totalpasscalif
	 
	from saleorders so 
	inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 	
	inner join 
	(
		select so.idsaleorders, so_sp.ciu, calibfchk.sn_unit,coalesce(calibfchk.sn_dib,'') as sn_module,so_sp.idband,
		coalesce(count(distinct calibfchk.id_it),0) as countdigmcalif,
		coalesce(max(calibfchk.id_it),0) as maxiditcalif , coalesce(max(so_sp.idrev),0) as maxidrev
		from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
		inner join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 0
		where so.idsaleorders = ".$v_idsaleordersBD." and so_sp.ciu ='$v_idciu' and calibfchk.sn_unit ='$v_sn' and calibfchk.band = $v_idband
		group by so.idsaleorders, so_sp.ciu, calibfchk.sn_unit , so_sp.idband,sn_module		
		
	) as maxcalif	 	
	on maxcalif.sn_unit = so_sp.sn_unit and 
	   maxcalif.ciu = so_sp.ciu and
	   maxcalif.idsaleorders = so_sp.idsaleorders and
	   maxcalif.idband = so_sp.idband  and
	   maxcalif.maxidrev   = so_sp.idrev and
	   so_sp.idband =$v_idband
	inner join calibrationfinalcheck as calibfchk2  
	on calibfchk2.sn_unit = maxcalif.sn_unit 
	and calibfchk2.ciu_unit = maxcalif.ciu  
	and calibfchk2.id_it = maxcalif.maxiditcalif 
	and calibfchk2.step = 0	
	and calibfchk2.sn_unit ='$v_sn'
	and calibfchk2.band = ".$v_idband." 
	where so.idsaleorders = ".$v_idsaleordersBD." and so_sp.ciu ='$v_idciu' and  so_sp.sn_unit='$v_sn' order by totalpasscalif desc limit 1";
	  return $valor_devuelto;
	}

	function list_show_SO_CIU_SN_calibfinalchk($v_idsaleordersBD, $v_idciu, $v_sn, $v_idband)
	{
	  $valor_devuelto= "select distinct coalesce(  so_sp.sn_unit,' --') sn, so_sp.idband,
	
	  maxcalif.sn_module as sn_modulecf, maxiditcalif,countdigmcalif ,calibfchk2.totalpass as totalpasscalif
	 
	from saleorders so 
	inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 	
	inner join 
	(
		select so.idsaleorders, so_sp.ciu, calibfchk.sn_unit,coalesce(calibfchk.sn_dib,'') as sn_module,so_sp.idband,
		coalesce(count(distinct calibfchk.id_it),0) as countdigmcalif,
		coalesce(max(calibfchk.id_it),0) as maxiditcalif , coalesce(max(so_sp.idrev),0) as maxidrev
		from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
		inner join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 1
		where so.idsaleorders = ".$v_idsaleordersBD." and so_sp.ciu ='$v_idciu' and calibfchk.sn_unit ='$v_sn' and calibfchk.band = $v_idband
		group by so.idsaleorders, so_sp.ciu, calibfchk.sn_unit , so_sp.idband,sn_module	
		
	) as maxcalif	 	
	on maxcalif.sn_unit = so_sp.sn_unit and 
	   maxcalif.ciu = so_sp.ciu and
	   maxcalif.idsaleorders = so_sp.idsaleorders and
	   maxcalif.idband = so_sp.idband  and
	   maxcalif.maxidrev   = so_sp.idrev and
	   so_sp.idband =$v_idband	
	inner join calibrationfinalcheck as calibfchk2  
	on calibfchk2.sn_unit = maxcalif.sn_unit 
	and calibfchk2.ciu_unit = maxcalif.ciu  
	and calibfchk2.id_it = maxcalif.maxiditcalif 
	and calibfchk2.step = 1	
	and calibfchk2.sn_unit ='$v_sn'
	and calibfchk2.band = ".$v_idband." 
	where so.idsaleorders = ".$v_idsaleordersBD." and so_sp.ciu ='$v_idciu' and  so_sp.sn_unit='$v_sn' order by totalpasscalif desc limit 1 ";
	  return $valor_devuelto;
	}
	
	
	function list_show_ciu_sn_info_subband($v_idciu, $v_snunit)
	{
	  $valor_devuelto= "select  so_sp.ifdualband ,so_sp.idband, so_sp.idrev, so_sp_subband.idsubband, so_sp_subband.ul_start,so_sp_subband.ul_center, so_sp_subband.ul_stop,
so_sp_subband.dl_start, so_sp_subband.dl_center, so_sp_subband.dl_stop
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
inner join saleorders_specs_subband as so_sp_subband
on		 so_sp_subband.idcustomers	= so_sp.idcustomers and
		so_sp_subband.idsaleorders 	= so_sp.idsaleorders and
		so_sp_subband.ciu 			= so_sp.ciu and
		so_sp_subband.sn_unit		= so_sp.sn_unit and
		so_sp_subband.idrev			= so_sp.idrev and
		so_sp_subband.idband			= so_sp.idband	

 where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."'
order by so_sp.idband, so_sp.idrev asc	

 ";
	  return $valor_devuelto;
	}
	
	
		function list_show_ciu_sn_info_subband_maxrev($v_idciu, $v_snunit)
	{
	  $valor_devuelto= "select  so_sp.ifdualband ,so_sp.idband, so_sp.idrev, so_sp_subband.idsubband, so_sp_subband.ul_start,so_sp_subband.ul_center, so_sp_subband.ul_stop,
so_sp_subband.dl_start, so_sp_subband.dl_center, so_sp_subband.dl_stop
from saleorders so 
inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
inner join saleorders_specs_subband as so_sp_subband
on		 so_sp_subband.idcustomers	= so_sp.idcustomers and
		so_sp_subband.idsaleorders 	= so_sp.idsaleorders and
		so_sp_subband.ciu 			= so_sp.ciu and
		so_sp_subband.sn_unit		= so_sp.sn_unit and
		so_sp_subband.idrev			= so_sp.idrev and
		so_sp_subband.idband			= so_sp.idband	
inner join (
					select so.idcustomers ,so.idsaleorders, so_sp.ciu,  so_sp.sn_unit,so_sp.idband,	so_sp.ifdualband,
					coalesce(max(so_sp.idrev),0) as maxidrev
					from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
					where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."'
					group by so.idcustomers ,so.idsaleorders, so_sp.ciu,  so_sp.sn_unit,so_sp.idband,so_sp.ifdualband
			) as maxbanrevciuunit
on maxbanrevciuunit.idcustomers	= so_sp.idcustomers and
		maxbanrevciuunit.idsaleorders 	= so_sp.idsaleorders and
		maxbanrevciuunit.ciu 			= so_sp.ciu and
		maxbanrevciuunit.sn_unit		= so_sp.sn_unit and
		maxbanrevciuunit.maxidrev			= so_sp.idrev and
		maxbanrevciuunit.idband			= so_sp.idband	
 where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."'
order by so_sp.idband, so_sp.idrev asc	

 ";
	  return $valor_devuelto;
	}
	
	
	
	function list_show_ciu_sn_info($v_idciu, $v_snunit)
	{
	  $valor_devuelto= "select so_sp.idband, so_sp.idrev, COALESCE (so_sp.date_approved,'') as date_approved , 
case when coalesce(pwrsupplytype,'')='' then '-' when pwrsupplytype='null' then '-' else pwrsupplytype end as  pwrsupplytype,
case when coalesce(ponumber,'')='' then '-' when ponumber='null' then '-' else ponumber end as  ponumber,
case when coalesce(rcgfbwa,'')='' then '-' when rcgfbwa='null' then '-' else rcgfbwa end as  rcgfbwa,
case when coalesce(moden_dig,'')='' then '-' when moden_dig='false' then 'false' when moden_dig='null' then '-' end as  moden_dig,
case when coalesce(descripcion,'')='' then '-' when descripcion='null' then '-' else descripcion end as  descripcion,
COALESCE (ul_gain,'') as  ul_gain,
COALESCE (ul_max_pwr,'') as  ul_max_pwr,
COALESCE (ul_start,'') as  ul_start,
COALESCE (ul_stop,'') as  ul_stop ,
COALESCE (dl_gain,'') as  dl_gain,
COALESCE (dl_max_pwr,'') as  dl_max_pwr,
COALESCE (dl_start,'') as  dl_start,
COALESCE (dl_stop,'') as  dl_stop ,so_sp.idruninfo,so_sp.ifdualband,
case when so_sp.idruninfo = 0 then '-' when so_sp.idruninfo >0 then trim(runinfo.userruninfo) end as userruninfo 

from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders left join runinfo


on runinfo.idruninfo = so_sp.idruninfo where sn_unit = '".$v_snunit."' and ciu ='".$v_idciu."' order by so_sp.idband, so_sp.idrev asc	 ";
	  return $valor_devuelto;
	}
	
		function list_show_ciu_sn_info_maxrev($v_idciu, $v_snunit)
	{
	  $valor_devuelto= "select so_sp.idband, so_sp.idrev, COALESCE (so_sp.date_approved,'') as date_approved , 
case when coalesce(pwrsupplytype,'')='' then '-' when pwrsupplytype='null' then '-' else pwrsupplytype end as  pwrsupplytype,
case when coalesce(ponumber,'')='' then '-' when ponumber='null' then '-' else ponumber end as  ponumber,
case when coalesce(rcgfbwa,'')='' then '-' when rcgfbwa='null' then '-' else rcgfbwa end as  rcgfbwa,
case when coalesce(moden_dig,'')='' then '-' when moden_dig='false' then 'false' when moden_dig='null' then '-' end as  moden_dig,
case when coalesce(descripcion,'')='' then '-' when descripcion='null' then '-' else descripcion end as  descripcion,
COALESCE (ul_gain,'') as  ul_gain,
COALESCE (ul_max_pwr,'') as  ul_max_pwr,
COALESCE (ul_start,'') as  ul_start,
COALESCE (ul_stop,'') as  ul_stop ,
COALESCE (dl_gain,'') as  dl_gain,
COALESCE (dl_max_pwr,'') as  dl_max_pwr,
COALESCE (dl_start,'') as  dl_start,
COALESCE (dl_stop,'') as  dl_stop ,so_sp.idruninfo,so_sp.ifdualband,
case when so_sp.idruninfo = 0 then '-' when so_sp.idruninfo >0 then trim(runinfo.userruninfo) end as userruninfo 

from saleorders so inner
 join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
inner join (
					select so.idcustomers ,so.idsaleorders, so_sp.ciu,  so_sp.sn_unit,so_sp.idband,	so_sp.ifdualband,
					coalesce(max(so_sp.idrev),0) as maxidrev
					from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
					where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."'
					group by so.idcustomers ,so.idsaleorders, so_sp.ciu,  so_sp.sn_unit,so_sp.idband,so_sp.ifdualband
			) as maxbanrevciuunit
on maxbanrevciuunit.idcustomers	= so_sp.idcustomers and
		maxbanrevciuunit.idsaleorders 	= so_sp.idsaleorders and
		maxbanrevciuunit.ciu 			= so_sp.ciu and
		maxbanrevciuunit.sn_unit		= so_sp.sn_unit and
		maxbanrevciuunit.maxidrev			= so_sp.idrev and
		maxbanrevciuunit.idband			= so_sp.idband			
left join runinfo
on runinfo.idruninfo = so_sp.idruninfo where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."' order by so_sp.idband, so_sp.idrev asc	 ";
	  return $valor_devuelto;
	}
	
		function list_show_ciu_sn_info_ch_maxrev	($v_idciu, $v_snunit)
	{
		
			
		$valor_devuelto="select so_sp.ifdualband, so_sp.idband,	
		so_sp.idrev ,sosp_ch.idch,sosp_ch.ul_ch_fr,sosp_ch.dl_ch_fr
		from saleorders so 
		inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
		inner join saleorders_specs_ch sosp_ch 
		on so_sp.idcustomers	= sosp_ch.idcustomers and
		so_sp.idsaleorders 	= sosp_ch.idsaleorders and
		so_sp.ciu 			= sosp_ch.ciu and
		so_sp.sn_unit		= sosp_ch.sn_unit and
		so_sp.idrev			= sosp_ch.idrev and
		so_sp.idband			= sosp_ch.idband
		inner join (
					select so.idcustomers ,so.idsaleorders, so_sp.ciu,  so_sp.sn_unit,so_sp.idband,	so_sp.ifdualband,
					coalesce(max(so_sp.idrev),0) as maxidrev
					from saleorders so inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
					where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."'
					group by so.idcustomers ,so.idsaleorders, so_sp.ciu,  so_sp.sn_unit,so_sp.idband,so_sp.ifdualband
			) as maxbanrevciuunit
		on maxbanrevciuunit.idcustomers	= sosp_ch.idcustomers and
		maxbanrevciuunit.idsaleorders 	= sosp_ch.idsaleorders and
		maxbanrevciuunit.ciu 			= sosp_ch.ciu and
		maxbanrevciuunit.sn_unit		= sosp_ch.sn_unit and
		maxbanrevciuunit.maxidrev			= sosp_ch.idrev and
		maxbanrevciuunit.idband			= sosp_ch.idband	
		
		where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."' 	order by  so_sp.idrev asc ,sosp_ch.idch asc   ";	
			
		return $valor_devuelto;
		
	}

		function list_show_ciu_sn_info_ch	($v_idciu, $v_snunit)
	{
		
		$valor_devuelto="select so_sp.ifdualband, so_sp.idband,	
		so_sp.idrev ,sosp_ch.idch,sosp_ch.ul_ch_fr,sosp_ch.dl_ch_fr
		from saleorders so 
		inner join saleorders_specs so_sp on so.idsaleorders = so_sp.idsaleorders 
		inner join saleorders_specs_ch sosp_ch 
		on so_sp.idcustomers	= sosp_ch.idcustomers and
		so_sp.idsaleorders 	= sosp_ch.idsaleorders and
		so_sp.ciu 			= sosp_ch.ciu and
		so_sp.sn_unit		= sosp_ch.sn_unit and
		so_sp.idrev			= sosp_ch.idrev and
		so_sp.idband			= sosp_ch.idband
		where so_sp.sn_unit = '".$v_snunit."' and so_sp.ciu ='".$v_idciu."' 	order by  so_sp.idrev asc ,sosp_ch.idch asc   ";
		
	
			
		return $valor_devuelto;
		
	}
	
		function list_show_SN_by_CIU($tipoplaca, $v_BDciu)
	{
		if ($tipoplaca=="ACF")
		{
			$valor_devuelto= "select distinct 'ACF' as typeaccept, sn, ciu from acceptacf where ciu='".$v_BDciu."' order  by sn";	
		}
		if ($tipoplaca=="DB")
		{
			$valor_devuelto= "select distinct 'DB' as typeaccept, sn, ciu from acceptdib where ciu='".$v_BDciu."' order by sn";	
		}
		if ($tipoplaca=="PA")
		{
			$valor_devuelto= "select distinct 'PA' as typeaccept, sn, ciu from acceptpa where ciu='".$v_BDciu."' order by sn";	
		}
	  

	  return $valor_devuelto;
	}
	
	function list_acceptante_count_report1()
	{
		  $valor_devuelto= "select distinct 'ACF' as typeaccept, sn, ciu from acceptacf  union select distinct 'DB' as typeaccept, sn, ciu from acceptdib union  select distinct 'PA' as typeaccept, sn, ciu from acceptpa order by typeaccept, ciu,sn ";
		 $valor_devuelto=" select distinct 'ACF' as typeaccept, ciu, count(distinct sn)  as cc,  array_agg(coalesce(sn,'')) as groupxsn
from acceptacf group by typeaccept, ciu
union 
select distinct 'DB' as typeaccept,  ciu, count(distinct sn)  as cc, array_agg(coalesce(sn,'')) as groupxsn
from acceptdib group by typeaccept, ciu
union  
select distinct 'PA' as typeaccept,  ciu, count(distinct sn)  as cc, array_agg(coalesce(sn,'')) as groupxsn
from acceptpa 
group by typeaccept, ciu
order by typeaccept, ciu  ";


 $valor_devuelto="select distinct 'DB' as typeaccept,  acceptdib.ciu, count(distinct sn)  as cc, array_agg(coalesce(sn,'')) as groupxsn,  coalesce(losaceptados.cc_totalpass,0)   as cctp
from acceptdib 
left join 
(	
	select   ciu, count(distinct sn)  as cc_totalpass from 	acceptdib where totalpass = 'true' group by  ciu
) as losaceptados
on acceptdib.ciu = losaceptados.ciu
group by typeaccept, acceptdib.ciu,losaceptados.cc_totalpass
union 
select distinct 'PA' as typeaccept,  acceptpa.ciu, count(distinct sn)  as cc, array_agg(coalesce(sn,'')) as groupxsn,  coalesce(losaceptados.cc_totalpass,0)   as cctp
from acceptpa 
left join 
(	
	select   ciu, count(distinct sn)  as cc_totalpass from 	acceptpa where totalpass = 'true' group by  ciu
) as losaceptados
on acceptpa.ciu = losaceptados.ciu
group by typeaccept, acceptpa.ciu,losaceptados.cc_totalpass
union
select distinct 'ACF' as typeaccept,  acceptacf.ciu, count(distinct sn)  as cc, array_agg(coalesce(sn,'')) as groupxsn,  coalesce(losaceptados.cc_totalpass,0)   as cctp
from acceptacf 
left join 
(	
	select   ciu, count(distinct sn)  as cc_totalpass from 	acceptacf where totalpass = 'true' group by  ciu
) as losaceptados
on acceptacf.ciu = losaceptados.ciu
group by typeaccept, acceptacf.ciu,losaceptados.cc_totalpass
order by  typeaccept,  ciu";




	  return $valor_devuelto;
	}
	

	function list_digmodule ($v_sn_unit, $v_sn_module)
	{
		$valor_devuelto="select band,idit, runinfo.dateinfo, timescript, userruninfo,station,fasver,  totalpass, fws,   sn_module, sn_unit, ciu_unit, ciu_module ,digmodule.idruninfo  as idruninfo 
from digmodule
inner join runinfo
on runinfo.idruninfo = digmodule.idruninfo  where sn_unit = '".$v_sn_unit."' and sn_module = '".$v_sn_module."' order by band,idit";
		
		return $valor_devuelto;
		
	}
	
	function list_digmodulecalif ($v_sn_unit, $v_sn_module)
	{
		$valor_devuelto="select band,id_it, runinfo.dateinfo,timescriptsteps,userruninfo,station,fasver,  totalpass, fws, coalesce(sn_dib,'') as sn_dib , coalesce(sn_palp,'') as sn_palp ,coalesce(sn_pahp,'' ) as sn_pahp, coalesce(sn_unit,'') as sn_unit, ciu_dib, ciu_palp, ciu_pahp, ciu_unit, freq, calibrationfinalcheck.idruninfo as idruninfo,eqbda

from calibrationfinalcheck
inner join runinfo
on runinfo.idruninfo = calibrationfinalcheck.idruninfo
 where sn_unit = '".$v_sn_unit."' and sn_dib = '".$v_sn_module."' and step = 0 order by band,id_it";
		
		return $valor_devuelto;
		
	}
	
	/*
	   isBDA return 0;
		isBDA && isFirstNet return 1
		isMaster return 2
		isMaster && isWMATA return 3
		isRemote return 4
		isRemote && isWMATA return 5
		isSCA return 6
		
		IF idtipociu = 0 THEN UTILIZAR COLUMNA DE LA BASE eqbda
		IF idtipociu = 1 THEN UTILIZAR COLUMNA DE LA BASE eqbda, eqfirstnet
		IF idtipociu = 2 THEN UTILIZAR COLUMNA DE LA BASE eqdas
		IF idtipociu = 3 THEN UTILIZAR COLUMNA DE LA BASE eqdas
		IF idtipociu = 4 THEN UTILIZAR COLUMNA DE LA BASE eqdas
		IF idtipociu = 5 THEN UTILIZAR COLUMNA DE LA BASE eqdas
		IF idtipociu = 6 THEN UTILIZAR COLUMNA DE LA BASE ????
		
		
		----	select case when idtipociu = 0 then eqbda when idtipociu = 1  then eqfirstnet when idtipociu = 2 then eqdas
         		when idtipociu = 3  then eqdas  when idtipociu = 4 then eqdas when idtipociu = 5  then eqdas when idtipociu = 6  then eqdas   end as  eqbda,
	*/
	
		function list_digmodulecalif_eq ($v_sn_unit, $v_sn_module)
	{
		$valor_devuelto="select eqbda, eqdas,eqfirstnet, idtipociu , eqripple 		
from calibrationfinalcheck
inner join runinfo
on runinfo.idruninfo = calibrationfinalcheck.idruninfo
 where sn_unit = '".$v_sn_unit."' and sn_dib = '".$v_sn_module."' and step = 0 order by band,id_it";
		
		return $valor_devuelto;
		
	}
	
	function list_digmodulecalif_factory ($v_sn_unit, $v_sn_module)
	{
		$valor_devuelto="select a_agcinthr,b_gain, c_maxpwr,d_nf,e_maxinpwr,f_oip3,g_sq,   *
from calibrationfinalcheck
inner join runinfo
on runinfo.idruninfo = calibrationfinalcheck.idruninfo
 where sn_unit = '".$v_sn_unit."' and sn_dib = '".$v_sn_module."' and step = 0 order by band,id_it";
		
		return $valor_devuelto;
		
	}
	
		function list_digmodulecalif_finalcheck ($v_sn_unit, $v_sn_module)
	{
		$valor_devuelto="select a_agcinthr,b_gain, c_maxpwr,d_nf,e_maxinpwr,f_oip3,g_sq,   *
from calibrationfinalcheck
inner join runinfo
on runinfo.idruninfo = calibrationfinalcheck.idruninfo
 where sn_unit = '".$v_sn_unit."' and sn_dib = '".$v_sn_module."' and step = 1 order by band,id_it";
		
		return $valor_devuelto;
		
	}
	
	
	function list_accept_db_data($tipodb, $nameciu, $dbsn)
	{
		if ($tipodb == 3)
		{/// ACF
			$valor_devuelto="select distinct *, COALESCE (fasver,'')  as fasver2 from acceptacf inner join runinfo on runinfo.idruninfo = acceptacf.idacceptacf  where sn = '".$dbsn."' and ciu = '".$nameciu."' order by idacceptacf asc ";
		}
		if ($tipodb == 1)
		{/// DIB
			$valor_devuelto="select distinct *, COALESCE (fasver,'')  as fasver2  from acceptdib inner join runinfo on runinfo.idruninfo = acceptdib.idacceptdib  where sn = '".$dbsn."' and ciu = '".$nameciu."' order by idacceptdib asc ";
		}
		if ($tipodb == 2)
		{/// PA
			$valor_devuelto="select distinct *, COALESCE (fasver,'')  as fasver2  from acceptpa inner join runinfo on runinfo.idruninfo = acceptpa.idacceptpa  where sn = '".$dbsn."' and ciu = '".$nameciu."' order by idacceptpa asc ";
		}
		
	
		return $valor_devuelto;
		
	}
	


		
?>