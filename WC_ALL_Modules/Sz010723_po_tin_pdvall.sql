with 
spk as 
( select w.*,
R11a_12a_13a_22,
R11a_12a_13a_23,
r18_22,
r18_23,
r19_22,
r19_23,
nav_22,
nav_23

from 
(select distinct v.tin, v.name from rg04.PDV_ACT_R v where v.IS_ACTUAL=1 and v.C_REG=6 )w
left join 

(SELECT   c_sti,tin,
 --SUM(CASE WHEN  c_doc_rowc in ('^R11GA')  THEN o1.ZN ELSE 0 END ) AS R11a, 	
 SUM(CASE WHEN period_year=2022 and c_doc_rowc in ('^R11GA','^R12GA','^R13GA')  THEN o1.ZN ELSE 0 END ) AS R11a_12a_13a_22, 	
 SUM(CASE WHEN period_year=2023 and c_doc_rowc in ('^R11GA','^R12GA','^R13GA')  THEN o1.ZN ELSE 0 END ) AS R11a_12a_13a_23, 	
 --SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA','^R21GA','^R41GA','^R42GA','^R43GA','^R50GA','^R70GA')  THEN o1.ZN ELSE 0 END ) AS obsjag, 
 --SUM(CASE WHEN c_doc_rowc LIKE '^R12GA'  THEN o1.ZN ELSE 0 END ) AS r12, 
 --SUM(CASE WHEN c_doc_rowc in ('^R21GA','^R22GA','^R20GA')  THEN o1.ZN ELSE 0 END ) AS r20, 
 --SUM(CASE WHEN c_doc_rowc LIKE '^R111GA' THEN o1.ZN ELSE 0 END ) AS r111, 
 --SUM(CASE WHEN c_doc_rowc LIKE '^R112GA' THEN o1.ZN ELSE 0 END ) AS r112, 
 SUM(CASE WHEN period_year=2022 and c_doc_rowc LIKE '^R180GB' THEN o1.ZN ELSE 0 END ) AS r18_22, 
 SUM(CASE WHEN period_year=2023 and c_doc_rowc LIKE '^R180GB' THEN o1.ZN ELSE 0 END ) AS r18_23, 
 SUM(CASE WHEN period_year=2022 and c_doc_rowc LIKE '^R190GB' THEN o1.ZN ELSE 0 END ) AS r19_22,
 SUM(CASE WHEN period_year=2023 and c_doc_rowc LIKE '^R190GB' THEN o1.ZN ELSE 0 END ) AS r19_23,
 round(SUM(CASE WHEN period_year=2022 and c_doc_rowc LIKE '^R180GB' THEN o1.ZN ELSE 0 END )*100/SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA')  THEN o1.ZN ELSE 0.0000000000000000001 END ) ,2) AS nav_22,
 round(SUM(CASE WHEN period_year=2023 and c_doc_rowc LIKE '^R180GB' THEN o1.ZN ELSE 0 END )*100/SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA')  THEN o1.ZN ELSE 0.0000000000000000001 END ) ,2) AS nav_23
  
 FROM 
 (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN 
 from 
 (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter, 
                                      MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin,a.period_year,a.PERIOD_MONTH) 
                                                                   AS max_cdrd,SUM(B.ZN) ZN 
   FROM dp00.T_zregdoc a left join dp00.T_ZDATA_N B on  A.cod_regdoc=B.cod_regdoc 
    WHERE   A.PERIOD_YEAR in (extract(year from sysdate)  )  
            and A.C_DOC||A.C_DOC_SUB IN('J02001','F02001')   
            AND tin in (select distinct v.tin from rg04.PDV_ACT_R v where v.IS_ACTUAL=1 and v.C_REG=6)
            and a.PERIOD_MONTH between 1 and 12
            and (BITAND (flags, 16) = 0  
             AND BITAND (flags, 2048) = 0  
             AND BITAND (flags, 1048576) = 0  
             AND BITAND (flags, 134217728) = 0)  
			 
     GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o 
    where o.cod_regdoc = o.max_cdrd ) o1 
 -- having SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA','^R21GA','^R41GA','^R42GA','^R43GA','^R50GA','^R70GA')  THEN o1.ZN ELSE 0 END )>=20000000   
    
  GROUP BY c_sti,tin)d   on to_char(w.tin) =to_char(d.tin) )




select 
  spk.*,
  t.name,
  t.C_NAME,
  t.C_STAN,
  kvd.sek, 
  t.KVED,
  kvd.nu name_kvd,
  o.OPP20,
  df.m1 "штат.прац.зв.1міс.кв",df.avgz_m1 "ср.зарп.1міс.кв",
  df.m2 "штат.прац.зв.2міс.кв",df.avgz_m2 "ср.зарп.2міс.кв", 
  df.m3 "штат.прац.зв.3міс.кв",df.avgz_m3 "ср.зарп.3міс.кв",
  spl_all_22,
  spl_pdv_22,
  spl_all_23,
  spl_pdv_23,
  zag_plosha 

from spk
 left join 
  rg02.r21taxpay_u t on  spk.TIN = t.TIN
  left join
   (select kod, sek,nu from etalon.e_kved  ) kvd on kvd.kod=t.kved 
  left join 
  UPR28.OPP20_TYPE o on spk.TIN = o.TIN
  left join
    (SELECT C_STI, o1.tin, period_year, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R101G3'  THEN o1.ZN ELSE 0 END ) AS m1, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R101G4'  THEN o1.ZN ELSE 0 END ) AS m2, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R101G5'  THEN o1.ZN ELSE 0 END ) AS m3,  

 round(SUM(CASE WHEN c_doc_rowc LIKE '^R0101G3'  THEN o1.ZN ELSE 0 END )/SUM(CASE WHEN c_doc_rowc LIKE '^R101G3'  THEN DECODE(o1.ZN,0,0.000000000000001,o1.ZN)  END )) AS avgz_m1, 
 round(SUM(CASE WHEN c_doc_rowc LIKE '^R0101G4'  THEN o1.ZN ELSE 0 END )/SUM(CASE WHEN c_doc_rowc LIKE '^R101G4'  THEN DECODE(o1.ZN,0,0.000000000000001,o1.ZN)  END )) AS avgz_m2, 
 round(SUM(CASE WHEN c_doc_rowc LIKE '^R0101G5'  THEN o1.ZN ELSE 0 END )/SUM(CASE WHEN c_doc_rowc LIKE '^R101G5'  THEN DECODE(o1.ZN,0,0.000000000000001,o1.ZN)  END )) AS avgz_m3  
 --  DECODE ( COUNT (x.vsi)- COUNT (x.likv),0,null, COUNT (x.vsi)- COUNT (x.likv)

 FROM 
 (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN 
 from 
 (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter, 
                                      MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin) 
                                                                   AS max_cdrd,SUM(B.ZN) ZN 
   FROM dp00.T_zregdoc a,dp00.T_ZDATA_N B 
    WHERE   A.PERIOD_YEAR in (extract(year from sysdate) ,extract(year from sysdate)-1)  
            and A.C_DOC||A.C_DOC_SUB IN ('J05001','F05001')   
            and B.c_doc_rowc  in ('^R101G3', '^R101G4', '^R101G5','^R0101G3', '^R0101G4', '^R0101G5' ) 
            AND A.cod_regdoc=B.cod_regdoc  
            and (BITAND (flags, 16) = 0  
             AND BITAND (flags, 2048) = 0  
             AND BITAND (flags, 1048576) = 0  
             AND BITAND (flags, 134217728) = 0)   
			 AND tin in (select distinct v.tin from rg04.PDV_ACT_R v where v.IS_ACTUAL=1 and v.C_REG=6)
   
     GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o 
    where o.cod_regdoc = o.max_cdrd ) o1 
    GROUP BY C_STI, o1.tin ,period_year) df  ON spk.tin=df.tin         
    
    LEFT join
  (SELECT  o1.tin, 
 SUM(CASE WHEN c_doc_rowc in ('^R011G11','^R012G11' ,'^R013G11' ,'^R014G11')  THEN o1.ZN ELSE 0 END ) AS zag_plosha 

 FROM 
 (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN 
 from 
 (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter, 
                                      MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin) 
                                                                   AS max_cdrd,SUM(B.ZN) ZN 
   FROM dp00.T_zregdoc a,dp00.T_ZDATA_N B 
    WHERE   A.PERIOD_YEAR in (extract(year from sysdate) ,extract(year from sysdate)-1)      
	        --AND a.period_month=12
            and A.C_DOC||A.C_DOC_SUB IN ('J01381','F01381')   
            and B.c_doc_rowc  in ('^R011G11','^R012G11' ,'^R013G11' ,'^R014G11'  ) 
            AND A.cod_regdoc=B.cod_regdoc  
            and (BITAND (flags, 16) = 0  
             AND BITAND (flags, 2048) = 0  
             AND BITAND (flags, 1048576) = 0  
             AND BITAND (flags, 134217728) = 0)   
			 AND tin in (select distinct v.tin from rg04.PDV_ACT_R v where v.IS_ACTUAL=1 and v.C_REG=6)
     GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o 
    where o.cod_regdoc = o.max_cdrd ) o1 
    GROUP BY  o1.tin ) ed  ON  spk.tin=ed.tin	
     
    left join
    (SELECT c_sti, kod,
          SUM (zn * DECODE (idparm,  104, 1,  58, -1,  0)* DECODE (rdata, '01.01.2023', 1, 0))                        spl_all_22 ,
          SUM (zn * DECODE (idparm,  104, 1,  58, -1,  0)* DECODE (rdata, '01.07.2023', 1, 0))                        spl_all_23 ,
          SUM (case when rdata='01.01.2023' and shot='14010100' and idparm=58 then -zn 
          when rdata='01.01.2023' and shot='14010100' and idparm=104 then zn else 0 end)                              spl_pdv_22,
          SUM (case when rdata='01.07.2023' and shot='14010100' and idparm=58 then -zn 
          when rdata='01.07.2023' and shot='14010100' and idparm=104 then zn else 0 end)                              spl_pdv_23
           
     FROM (SELECT * FROM galuz.vg306_pb 
           UNION 
           SELECT * FROM galuz.vf306) a 
    WHERE     rdata IN ('01.01.2023','01.07.2023')  
          AND  idparm IN (104,58 ) 
         AND kod in (select distinct v.tin from rg04.PDV_ACT_R v where v.IS_ACTUAL=1 and v.C_REG=6) 
 GROUP BY c_sti, kod ) g ON  spk.tin=g.kod  
         