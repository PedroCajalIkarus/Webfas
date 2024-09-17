<?php
error_reporting(0);
    include("db_conect.php"); 
		header('Content-Type: application/json');

		$idruninfo =$_REQUEST['idruninfo'];	
		
		////////////////////////  Calibration_EQ_Calibration_Tx //////////////////////////////////
$sqlmmhead="
select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop
	,ARRAY_AGG (    round( CAST(pwr_txconmedia as numeric),2) order by freq asc ) as arraypwr , ARRAY_AGG (   round( CAST(freq as numeric),2) order by freq asc) as arraylbl 
from
(


	select distinct  todoslospwr.bandnuevo, todoslospwr.uldl  , todoslospwr.iduniquebranch,  todoslospwr.script ,    todoslospwr.timename,
	 todoslospwr.iduniqueop , (pwr-((pwrmin+pwrmax)/2)) as pwr_txconmedia, freq
from
(
		select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, tt.iduniqueop, min (pwr) as pwrmin, max(pwr) as pwrmax
		from
		( 
		select distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
		,fas_mkrmeasures.pwr, freq 
		from fas_tree_measure 
		inner join
		(
			select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
		WHEN 0  THEN 0
		WHEN 3  THEN 0
		WHEN 4  THEN 1
		WHEN 8  THEN 1
		WHEN 7  THEN 1
		WHEN 1  THEN 1
		WHEN 6  THEN 1
		ELSE NULL
		END AS bandnuevo from  fas_routines_product 
			inner join fas_tree_product 
			on fas_tree_product.idproduct = fas_routines_product.idproduct
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
			and fas_tree.idfastree = fas_tree_product.idfastree
			inner join fas_step
			on fas_tree.idfastrepson = fas_step.idfasstep
			where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
			 
			and fas_routines_product.active = 'Y'
			order by idorden
		) as listroutime
		on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
		listroutime.bandnuevo =  fas_tree_measure.band and
		listroutime.uldl =  fas_tree_measure.uldl 
		
		inner join runinfodb
		on runinfodb.idruninfodb = fas_tree_measure.idrununfo
		inner join fas_times
		on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
		and fas_times.idsinglemeasure is null 
		and fas_times.idsameasures is null
		and fas_times.iducmeasure is null
		
		left join fas_mkrmeasures 
		on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop
			
		left join fas_ucmeasures
			on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
		
		inner join fas_times_type
		on fas_times_type.idtimetype = fas_times.idtimetype
		where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300A07D'
		order by id_mkrmeasures
			)as tt
		
		group by bandnuevo, uldl  , iduniquebranch,  script ,    timename, tt.iduniqueop 
		) as tt_minmax
		inner join 
		(
			 
			select distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
			,fas_mkrmeasures.pwr, freq
			from fas_tree_measure 
			inner join
			(
				select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
			WHEN 0  THEN 0
			WHEN 3  THEN 0
			WHEN 4  THEN 1
			WHEN 8  THEN 1
			WHEN 7  THEN 1
			WHEN 1  THEN 1
			WHEN 6  THEN 1
			ELSE NULL
			END AS bandnuevo from  fas_routines_product 
				inner join fas_tree_product 
				on fas_tree_product.idproduct = fas_routines_product.idproduct
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
				and fas_tree.idfastree = fas_tree_product.idfastree
				inner join fas_step
				on fas_tree.idfastrepson = fas_step.idfasstep
				where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 

				and fas_routines_product.active = 'Y'
				order by idorden
			) as listroutime
			on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
			listroutime.bandnuevo =  fas_tree_measure.band and
			listroutime.uldl =  fas_tree_measure.uldl 

			inner join runinfodb
			on runinfodb.idruninfodb = fas_tree_measure.idrununfo
			inner join fas_times
			on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
			and fas_times.idsinglemeasure is null 
			and fas_times.idsameasures is null
			and fas_times.iducmeasure is null

			left join fas_mkrmeasures 
			on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop

			left join fas_ucmeasures
				on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop

			inner join fas_times_type
			on fas_times_type.idtimetype = fas_times.idtimetype
			where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300A07D'
				order by freq
 
		) as todoslospwr
		on todoslospwr.bandnuevo = tt_minmax.bandnuevo and
		   todoslospwr.uldl = tt_minmax.uldl and
		   todoslospwr.iduniquebranch = tt_minmax.iduniquebranch and
		   todoslospwr.script= tt_minmax.script and 
	    	todoslospwr.iduniqueop = tt_minmax.iduniqueop
	  order by freq desc 
	) as final
	group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop
	
";
 
$tem="orange";
$dataheadr = $connect->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
		
		
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
			{
				$iduniqueop_band_0_uldl_0_tx_calib = substr($rowhead['arraypwr'],1,-1);
				$label_tx_calib_0_0 =  substr($rowhead['arraylbl'],1,-1);  
			}
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
			{
				$iduniqueop_band_0_uldl_1_tx_calib = substr($rowhead['arraypwr'],1,-1);
				$label_tx_calib_0_1 =  substr($rowhead['arraylbl'],1,-1);  
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
			{
				$iduniqueop_band_1_uldl_0_tx_calib = substr($rowhead['arraypwr'],1,-1);
				$label_tx_calib_1_0 =  substr($rowhead['arraylbl'],1,-1);  
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
			{
				$iduniqueop_band_1_uldl_1_tx_calib = substr($rowhead['arraypwr'],1	,-1);
				$label_tx_calib_1_1 =  substr($rowhead['arraylbl'],1,-1);  
			}
		 
	}
//////////////////////// FIN  Calibration_EQ_Calibration_Tx //////////////////////////////////
		////////////////////////  inicio Calibration_EQ_Calibration_Rx //////////////////////////////////
		$sqlmmhead="
		select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop
		,ARRAY_AGG (    round( CAST(pwr_txconmedia as numeric),2) order by freq asc ) as arraypwr , ARRAY_AGG (  freq order by freq asc) as arraylbl 
	from
	(
	
	
		select    todoslospwr.bandnuevo, todoslospwr.uldl  , todoslospwr.iduniquebranch,  todoslospwr.script ,    todoslospwr.timename,
		 todoslospwr.iduniqueop , (pwr-((pwrmin+pwrmax)/2)) as pwr_txconmedia, freq
	from
	(
		--------inicio aca2
			select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, tt.iduniqueop, min (pwr) as pwrmin, max(pwr) as pwrmax
			from
			( 
				-------- inicio aca1
			select distinct id_ucmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
			,fas_ucmeasures.uclevel as pwr,  0 as freq 
			from fas_tree_measure 
			inner join
			(
				select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
			WHEN 0  THEN 0
			WHEN 3  THEN 0
			WHEN 4  THEN 1
			WHEN 8  THEN 1
			WHEN 7  THEN 1
			WHEN 1  THEN 1
			WHEN 6  THEN 1
			ELSE NULL
			END AS bandnuevo from  fas_routines_product 
				inner join fas_tree_product 
				on fas_tree_product.idproduct = fas_routines_product.idproduct
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
				and fas_tree.idfastree = fas_tree_product.idfastree
				inner join fas_step
				on fas_tree.idfastrepson = fas_step.idfasstep
				where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
				 
				and fas_routines_product.active = 'Y'
				order by idorden
			) as listroutime
			on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
			listroutime.bandnuevo =  fas_tree_measure.band and
			listroutime.uldl =  fas_tree_measure.uldl 
			
			inner join runinfodb
			on runinfodb.idruninfodb = fas_tree_measure.idrununfo
			inner join fas_times
			on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
			and fas_times.idsinglemeasure is null 
			and fas_times.idsameasures is null
			and fas_times.iducmeasure is null
		
			left join fas_ucmeasures
				on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
			
			inner join fas_times_type
			on fas_times_type.idtimetype = fas_times.idtimetype
			where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300A07E'
			order by id_ucmeasures
				
				--------aca1
				)as tt
			
			group by bandnuevo, uldl  , iduniquebranch,  script ,    timename, tt.iduniqueop 
		--------inicio aca2
			) as tt_minmax
			inner join 
			(
				 --------inicio aca3
				select distinct id_ucmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
				,fas_ucmeasures.uclevel as pwr, 0 as  freq 
				from fas_tree_measure 
				inner join
				(
					select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
				WHEN 0  THEN 0
				WHEN 3  THEN 0
				WHEN 4  THEN 1
				WHEN 8  THEN 1
				WHEN 7  THEN 1
				WHEN 1  THEN 1
				WHEN 6  THEN 1
				ELSE NULL
				END AS bandnuevo from  fas_routines_product 
					inner join fas_tree_product 
					on fas_tree_product.idproduct = fas_routines_product.idproduct
					inner join fas_tree
					on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
					and fas_tree.idfastree = fas_tree_product.idfastree
					inner join fas_step
					on fas_tree.idfastrepson = fas_step.idfasstep
					where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
	
					and fas_routines_product.active = 'Y'
					order by idorden
				) as listroutime
				on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
				listroutime.bandnuevo =  fas_tree_measure.band and
				listroutime.uldl =  fas_tree_measure.uldl 
	
				inner join runinfodb
				on runinfodb.idruninfodb = fas_tree_measure.idrununfo
				inner join fas_times
				on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
				and fas_times.idsinglemeasure is null 
				and fas_times.idsameasures is null
				and fas_times.iducmeasure is null
	
				inner join fas_ucmeasures
				on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
				
				 
				inner join fas_times_type
				on fas_times_type.idtimetype = fas_times.idtimetype
				where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300A07E'
					order by freq
				 --------fin aca3
	 
			) as todoslospwr
			on todoslospwr.bandnuevo = tt_minmax.bandnuevo and
			   todoslospwr.uldl = tt_minmax.uldl and
			   todoslospwr.iduniquebranch = tt_minmax.iduniquebranch and
			   todoslospwr.script= tt_minmax.script and 
				todoslospwr.iduniqueop = tt_minmax.iduniqueop
		  order by freq desc 
		) as final
		group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop 
		";
		 
		$tem="orange";
		$dataheadr = $connect->query($sqlmmhead)->fetchAll();
		foreach ($dataheadr as $rowhead) 
			{
				
				
					if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
					{
						$iduniqueop_band_0_uldl_0_rx_calib = substr($rowhead['arraypwr'],1,-1);
						$label_rx_calib_0_0 =  substr($rowhead['arraylbl'],1,-1); 
					}
					if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
					{
						$iduniqueop_band_0_uldl_1_rx_calib = substr($rowhead['arraypwr'],1,-1);
						$label_rx_calib_0_1 =  substr($rowhead['arraylbl'],1,-1); 
					}
					if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
					{
						$iduniqueop_band_1_uldl_0_rx_calib = substr($rowhead['arraypwr'],1,-1);
						$label_rx_calib_1_0 =  substr($rowhead['arraylbl'],1,-1); 
					}
					if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
					{
						$iduniqueop_band_1_uldl_1_rx_calib = substr($rowhead['arraypwr'],1	,-1);
						$label_rx_calib_1_1 =  substr($rowhead['arraylbl'],1,-1); 
					}
					
					
		
			   
			}
		//////////////////////// FIN  Calibration_EQ_Calibration_Rx //////////////////////////////////

		//////////////////////// Inicio Calibration_EQ_Check_Tx //////////////////////////////////
		$sqlmmhead="
		select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop
	,ARRAY_AGG (    round( CAST(pwr_txconmedia as numeric),2) order by freq asc ) as arraypwr , ARRAY_AGG (  freq order by freq asc) as arraylbl 
from
(


	select distinct  todoslospwr.bandnuevo, todoslospwr.uldl  , todoslospwr.iduniquebranch,  todoslospwr.script ,    todoslospwr.timename,
	 todoslospwr.iduniqueop , (pwr-((pwrmin+pwrmax)/2)) as pwr_txconmedia, freq
from
(
		select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, tt.iduniqueop, min (pwr) as pwrmin, max(pwr) as pwrmax
		from
		( 
		select distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
		,fas_mkrmeasures.pwr, freq 
		from fas_tree_measure 
		inner join
		(
			select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
		WHEN 0  THEN 0
		WHEN 3  THEN 0
		WHEN 4  THEN 1
		WHEN 8  THEN 1
		WHEN 7  THEN 1
		WHEN 1  THEN 1
		WHEN 6  THEN 1
		ELSE NULL
		END AS bandnuevo from  fas_routines_product 
			inner join fas_tree_product 
			on fas_tree_product.idproduct = fas_routines_product.idproduct
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
			and fas_tree.idfastree = fas_tree_product.idfastree
			inner join fas_step
			on fas_tree.idfastrepson = fas_step.idfasstep
			where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
			 
			and fas_routines_product.active = 'Y'
			order by idorden
		) as listroutime
		on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
		listroutime.bandnuevo =  fas_tree_measure.band and
		listroutime.uldl =  fas_tree_measure.uldl 
		
		inner join runinfodb
		on runinfodb.idruninfodb = fas_tree_measure.idrununfo
		inner join fas_times
		on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
		and fas_times.idsinglemeasure is null 
		and fas_times.idsameasures is null
		and fas_times.iducmeasure is null
		
		left join fas_mkrmeasures 
		on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop
			
		left join fas_ucmeasures
			on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
		
		inner join fas_times_type
		on fas_times_type.idtimetype = fas_times.idtimetype
		where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300B07F'
		order by id_mkrmeasures
			)as tt
		
		group by bandnuevo, uldl  , iduniquebranch,  script ,    timename, tt.iduniqueop 
		) as tt_minmax
		inner join 
		(
			 
			select distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
			,fas_mkrmeasures.pwr, freq
			from fas_tree_measure 
			inner join
			(
				select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
			WHEN 0  THEN 0
			WHEN 3  THEN 0
			WHEN 4  THEN 1
			WHEN 8  THEN 1
			WHEN 7  THEN 1
			WHEN 1  THEN 1
			WHEN 6  THEN 1
			ELSE NULL
			END AS bandnuevo from  fas_routines_product 
				inner join fas_tree_product 
				on fas_tree_product.idproduct = fas_routines_product.idproduct
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
				and fas_tree.idfastree = fas_tree_product.idfastree
				inner join fas_step
				on fas_tree.idfastrepson = fas_step.idfasstep
				where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 

				and fas_routines_product.active = 'Y'
				order by idorden
			) as listroutime
			on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
			listroutime.bandnuevo =  fas_tree_measure.band and
			listroutime.uldl =  fas_tree_measure.uldl 

			inner join runinfodb
			on runinfodb.idruninfodb = fas_tree_measure.idrununfo
			inner join fas_times
			on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
			and fas_times.idsinglemeasure is null 
			and fas_times.idsameasures is null
			and fas_times.iducmeasure is null

			left join fas_mkrmeasures 
			on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop

			left join fas_ucmeasures
				on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop

			inner join fas_times_type
			on fas_times_type.idtimetype = fas_times.idtimetype
			where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300B07F'
				order by freq
 
		) as todoslospwr
		on todoslospwr.bandnuevo = tt_minmax.bandnuevo and
		   todoslospwr.uldl = tt_minmax.uldl and
		   todoslospwr.iduniquebranch = tt_minmax.iduniquebranch and
		   todoslospwr.script= tt_minmax.script and 
	    	todoslospwr.iduniqueop = tt_minmax.iduniqueop
	  order by freq desc 
	) as final
	group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop
	
 
		";
		 
		$tem="orange";
		$dataheadrrx = $connect->query($sqlmmhead)->fetchAll();
		foreach ($dataheadrrx as $rowheadrx) 
			{
				
				
					if ($rowheadrx['bandnuevo'] == 0 && $rowheadrx['uldl']==0)
					{
						$iduniqueop_band_0_uldl_0_tx_check = substr($rowheadrx['arraypwr'],1,-1);
						$label_tx_check_0_0 =  substr($rowheadrx['arraylbl'],1,-1);   
					}
					if ($rowheadrx['bandnuevo'] == 0 && $rowheadrx['uldl']==1)
					{
						$iduniqueop_band_0_uldl_1_tx_check = substr($rowheadrx['arraypwr'],1,-1);
						$label_tx_check_0_1 =  substr($rowheadrx['arraylbl'],1,-1);   
					}
					if ($rowheadrx['bandnuevo'] == 1 && $rowheadrx['uldl']==0)
					{
						$iduniqueop_band_1_uldl_0_tx_check = substr($rowheadrx['arraypwr'],1,-1);
						$label_tx_check_1_0 =  substr($rowheadrx['arraylbl'],1,-1);   
					}
					if ($rowheadrx['bandnuevo'] == 1 && $rowheadrx['uldl']==1)
					{
						$iduniqueop_band_1_uldl_1_tx_check = substr($rowheadrx['arraypwr'],1	,-1);
						$label_tx_check_1_1 =  substr($rowheadrx['arraylbl'],1,-1);   
					}
					
					
		
			   
			}
		//////////////////////// FIN  Calibration_EQ_Check_Tx //////////////////////////////////
			//////////////////////// Inicio Calibration_EQ_Check_Rx //////////////////////////////////
			$sqlmmhead="
			select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop
			,ARRAY_AGG (    round( CAST(pwr_txconmedia as numeric),2) order by freq asc ) as arraypwr , ARRAY_AGG (  freq order by freq asc) as arraylbl 
		from
		(
		
		
			select    todoslospwr.bandnuevo, todoslospwr.uldl  , todoslospwr.iduniquebranch,  todoslospwr.script ,    todoslospwr.timename,
			 todoslospwr.iduniqueop , (pwr-((pwrmin+pwrmax)/2)) as pwr_txconmedia, freq
		from
		(
			--------inicio aca2
				select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, tt.iduniqueop, min (pwr) as pwrmin, max(pwr) as pwrmax
				from
				( 
					-------- inicio aca1
				select distinct id_ucmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
				,fas_ucmeasures.uclevel as pwr,  0 as freq 
				from fas_tree_measure 
				inner join
				(
					select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
				WHEN 0  THEN 0
				WHEN 3  THEN 0
				WHEN 4  THEN 1
				WHEN 8  THEN 1
				WHEN 7  THEN 1
				WHEN 1  THEN 1
				WHEN 6  THEN 1
				ELSE NULL
				END AS bandnuevo from  fas_routines_product 
					inner join fas_tree_product 
					on fas_tree_product.idproduct = fas_routines_product.idproduct
					inner join fas_tree
					on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
					and fas_tree.idfastree = fas_tree_product.idfastree
					inner join fas_step
					on fas_tree.idfastrepson = fas_step.idfasstep
					where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
					 
					and fas_routines_product.active = 'Y'
					order by idorden
				) as listroutime
				on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
				listroutime.bandnuevo =  fas_tree_measure.band and
				listroutime.uldl =  fas_tree_measure.uldl 
				
				inner join runinfodb
				on runinfodb.idruninfodb = fas_tree_measure.idrununfo
				inner join fas_times
				on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
				and fas_times.idsinglemeasure is null 
				and fas_times.idsameasures is null
				and fas_times.iducmeasure is null
			
				left join fas_ucmeasures
					on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
				
				inner join fas_times_type
				on fas_times_type.idtimetype = fas_times.idtimetype
				where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300B080'
				order by id_ucmeasures
					
					--------aca1
					)as tt
				
				group by bandnuevo, uldl  , iduniquebranch,  script ,    timename, tt.iduniqueop 
			--------inicio aca2
				) as tt_minmax
				inner join 
				(
					 --------inicio aca3
					select distinct id_ucmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
					,fas_ucmeasures.uclevel as pwr, 0 as  freq 
					from fas_tree_measure 
					inner join
					(
						select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
					WHEN 0  THEN 0
					WHEN 3  THEN 0
					WHEN 4  THEN 1
					WHEN 8  THEN 1
					WHEN 7  THEN 1
					WHEN 1  THEN 1
					WHEN 6  THEN 1
					ELSE NULL
					END AS bandnuevo from  fas_routines_product 
						inner join fas_tree_product 
						on fas_tree_product.idproduct = fas_routines_product.idproduct
						inner join fas_tree
						on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
						and fas_tree.idfastree = fas_tree_product.idfastree
						inner join fas_step
						on fas_tree.idfastrepson = fas_step.idfasstep
						where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
		
						and fas_routines_product.active = 'Y'
						order by idorden
					) as listroutime
					on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
					listroutime.bandnuevo =  fas_tree_measure.band and
					listroutime.uldl =  fas_tree_measure.uldl 
		
					inner join runinfodb
					on runinfodb.idruninfodb = fas_tree_measure.idrununfo
					inner join fas_times
					on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
					and fas_times.idsinglemeasure is null 
					and fas_times.idsameasures is null
					and fas_times.iducmeasure is null
		
					inner join fas_ucmeasures
					on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
					
					 
					inner join fas_times_type
					on fas_times_type.idtimetype = fas_times.idtimetype
					where idrununfo = ".$idruninfo."    and listroutime.iduniquebranch = '00100300B080'
						order by freq
					 --------fin aca3
		 
				) as todoslospwr
				on todoslospwr.bandnuevo = tt_minmax.bandnuevo and
				   todoslospwr.uldl = tt_minmax.uldl and
				   todoslospwr.iduniquebranch = tt_minmax.iduniquebranch and
				   todoslospwr.script= tt_minmax.script and 
					todoslospwr.iduniqueop = tt_minmax.iduniqueop
			  order by freq desc 
			) as final
			group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop 
				 
		 
		 
			";
			//////////////////////// fin Calibration_EQ_Check_Rx //////////////////////////////////
			 
			$tem="orange";
			$dataheadrrx = $connect->query($sqlmmhead)->fetchAll();
			foreach ($dataheadrrx as $rowheadrx) 
				{
					
					
						if ($rowheadrx['bandnuevo'] == 0 && $rowheadrx['uldl']==0)
						{
							$iduniqueop_band_0_uldl_0_rx_check = substr($rowheadrx['arraypwr'],1,-1);
							$label_rx_check_0_0 =  substr($rowheadrx['arraylbl'],1,-1); 
						}
						if ($rowheadrx['bandnuevo'] == 0 && $rowheadrx['uldl']==1)
						{
							$iduniqueop_band_0_uldl_1_rx_check = substr($rowheadrx['arraypwr'],1,-1);
							$label_rx_check_0_1 =  substr($rowheadrx['arraylbl'],1,-1); 
						}
						if ($rowheadrx['bandnuevo'] == 1 && $rowheadrx['uldl']==0)
						{
							$iduniqueop_band_1_uldl_0_rx_check = substr($rowheadrx['arraypwr'],1,-1);
							$label_rx_check_1_0 =  substr($rowheadrx['arraylbl'],1,-1); 
						}
						if ($rowheadrx['bandnuevo'] == 1 && $rowheadrx['uldl']==1)
						{
							$iduniqueop_band_1_uldl_1_rx_check = substr($rowheadrx['arraypwr'],1,-1);
							$label_rx_check_1_1 =  substr($rowheadrx['arraylbl'],1,-1); 
						}
						
				}
			//////////////////////// FIN  Calibration_EQ_Check_Rx //////////////////////////////////
				
			 
echo(json_encode(["label_tx_check"=>$label_tx_check,"label_tx_calib"=>$label_tx_calib,"iduniqueop_band_0_uldl_0_tx_calib"=>$iduniqueop_band_0_uldl_0_tx_calib,  "iduniqueop_band_0_uldl_1_tx_calib"=>$iduniqueop_band_0_uldl_1_tx_calib,"iduniqueop_band_1_uldl_0_tx_calib"=>$iduniqueop_band_1_uldl_0_tx_calib,  "iduniqueop_band_1_uldl_1_tx_calib"=>$iduniqueop_band_1_uldl_1_tx_calib,"iduniqueop_band_0_uldl_0_rx_calib"=>$iduniqueop_band_0_uldl_0_rx_calib,  "iduniqueop_band_0_uldl_1_rx_calib"=>$iduniqueop_band_0_uldl_1_rx_calib,"iduniqueop_band_1_uldl_0_rx_calib"=>$iduniqueop_band_1_uldl_0_rx_calib,  "iduniqueop_band_1_uldl_1_rx_calib"=>$iduniqueop_band_1_uldl_1_rx_calib,"iduniqueop_band_0_uldl_0_rx_check"=>$iduniqueop_band_0_uldl_0_rx_check,  "iduniqueop_band_0_uldl_1_rx_check"=>$iduniqueop_band_0_uldl_1_rx_check,"iduniqueop_band_1_uldl_0_rx_check"=>$iduniqueop_band_1_uldl_0_rx_check,  "iduniqueop_band_1_uldl_1_rx_check"=>$iduniqueop_band_1_uldl_1_rx_check ,"iduniqueop_band_0_uldl_0_tx_check"=>$iduniqueop_band_0_uldl_0_tx_check,  "iduniqueop_band_0_uldl_1_tx_check"=>$iduniqueop_band_0_uldl_1_tx_check,"iduniqueop_band_1_uldl_0_tx_check"=>$iduniqueop_band_1_uldl_0_tx_check,  "iduniqueop_band_1_uldl_1_tx_check"=>$iduniqueop_band_1_uldl_1_tx_check,"label_rx_check_0_0"=>$label_rx_check_0_0,"label_rx_check_0_1"=>$label_rx_check_0_1,"label_rx_check_1_0"=>$label_rx_check_1_0,"label_rx_check_1_1"=>$label_rx_check_0_0,"label_tx_check_0_0"=>$label_tx_check_0_0,"label_tx_check_0_1"=>$label_tx_check_0_1,"label_tx_check_1_0"=>$label_tx_check_1_0,"label_tx_check_1_1"=>$label_tx_check_1_1,"label_rx_calib_0_0"=>$label_rx_calib_0_0,"label_rx_calib_0_1"=>$label_rx_calib_0_1,"label_rx_calib_1_0"=>$label_rx_calib_1_0,"label_rx_calib_1_1"=>$label_rx_calib_1_1,"label_tx_calib_0_0"=>$label_tx_calib_0_0,"label_tx_calib_0_1"=>$label_tx_calib_0_1,"label_tx_calib_1_0"=>$label_tx_calib_1_0,"label_tx_calib_1_1"=>$label_tx_calib_1_1 ]));


?>
