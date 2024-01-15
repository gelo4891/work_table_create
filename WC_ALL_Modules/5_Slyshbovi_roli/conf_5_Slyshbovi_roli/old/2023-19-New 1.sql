SELECT spk.tin, spk.name,
--rpn.code,rpn.inspprd,rpn.tin,rpn.crtdate,rpn.cp_tin,rpn.nmr,rpn.ndssm,
 -- rpn."номенклатура товару",rpn."код УКТЗ",
  df.m1 "штат.прац.зв.1міс.кв",df.avgz_m1 "ср.зарп.1міс.кв",
  df.m2 "штат.прац.зв.2міс.кв",df.avgz_m2 "ср.зарп.2міс.кв", 
  df.m3 "штат.прац.зв.3міс.кв",df.avgz_m3 "ср.зарп.3міс.кв",
  gal.spl_vsogo "СплачВсього010123",
  GAL.spl_pdv "СплачПдв010123",
  oz.BVOZnapoch "БалВартПочатПер", 
  oz.BVOZnakin "БалВартКінПер",
  pdv.obsjag "Обсяг Декл",         
  pdv.nav "Навантаження",pdv.r18 "Позитивне значення", pdv.r19 "Відємне значення" ,
  ED.zag_plosha "ЗагПлощЗемл"
 
from

 (select tin, name from RG04.PDV_ACT_R  p where p.tin in (492196,698420) and is_actual=1 )spk  

---------kilk prac--------
LEFT OUTER join
  (SELECT C_STI, o1.tin, period_year, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R101G3'  THEN o1.ZN ELSE 0 END ) AS m1, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R101G4'  THEN o1.ZN ELSE 0 END ) AS m2, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R101G5'  THEN o1.ZN ELSE 0 END ) AS m3,  

 round(SUM(CASE WHEN c_doc_rowc LIKE '^R0101G3'  THEN o1.ZN ELSE 0 END )/SUM(CASE WHEN c_doc_rowc LIKE '^R101G3'  THEN DECODE(o1.ZN,0,0.000000000000001,o1.ZN)  END )) AS avgz_m1, 
 round(SUM(CASE WHEN c_doc_rowc LIKE '^R0101G4'  THEN o1.ZN ELSE 0 END )/SUM(CASE WHEN c_doc_rowc LIKE '^R101G4'  THEN DECODE(o1.ZN,0,0.000000000000001,o1.ZN)  END )) AS avgz_m2, 
 round(SUM(CASE WHEN c_doc_rowc LIKE '^R0101G5'  THEN o1.ZN ELSE 0 END )/SUM(CASE WHEN c_doc_rowc LIKE '^R101G5'  THEN DECODE(o1.ZN,0,0.000000000000001,o1.ZN)  END )) AS avgz_m3  


 FROM 
 (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN 
 from 
 (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter, 
                                      MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin) 
                                                                   AS max_cdrd,SUM(B.ZN) ZN 
   FROM dp00.T_zregdoc a,dp00.T_ZDATA_N B 
    WHERE   A.PERIOD_YEAR in (extract(year from sysdate) )   
            and A.C_DOC||A.C_DOC_SUB IN ('J05001','F05001')   
            and B.c_doc_rowc  in ('^R101G3', '^R101G4', '^R101G5','^R0101G3', '^R0101G4', '^R0101G5' ) 
            AND A.cod_regdoc=B.cod_regdoc  
            and (BITAND (flags, 16) = 0  
             AND BITAND (flags, 2048) = 0  
             AND BITAND (flags, 1048576) = 0  
             AND BITAND (flags, 134217728) = 0)   
             AND tin in (492196,698420)
     GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o 
    where o.cod_regdoc = o.max_cdrd ) o1 
    GROUP BY C_STI, o1.tin ,period_year) df  ON spk.tin=df.tin  --AND spk."c_sti"=df.c_sti           
    -----------pdv------
    LEFT  join
    (SELECT   period_year, c_sti,tin,
 SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA')  THEN o1.ZN ELSE 0 END ) AS R11a_12a_13a,     
 SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA','^R21GA','^R41GA','^R42GA','^R43GA','^R50GA','^R70GA')  THEN o1.ZN ELSE 0 END ) AS obsjag, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R12GA'  THEN o1.ZN ELSE 0 END ) AS r12, 
 SUM(CASE WHEN c_doc_rowc in ('^R21GA','^R22GA','^R20GA')  THEN o1.ZN ELSE 0 END ) AS r20, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R111GA' THEN o1.ZN ELSE 0 END ) AS r111, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R112GA' THEN o1.ZN ELSE 0 END ) AS r112, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R180GB' THEN o1.ZN ELSE 0 END ) AS r18, 
 SUM(CASE WHEN c_doc_rowc LIKE '^R190GB' THEN o1.ZN ELSE 0 END ) AS r19,
 round(SUM(CASE WHEN c_doc_rowc LIKE '^R180GB' THEN o1.ZN ELSE 0 END )*100/SUM(CASE WHEN c_doc_rowc in ('^R11GA','^R12GA','^R13GA')  THEN o1.ZN ELSE 0.0000000000000000001 END ) ,2) AS nav 
 FROM 
 (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN 
 from 
 (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter, 
                                      MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin,a.period_year,a.PERIOD_MONTH) 
                                                                   AS max_cdrd,SUM(B.ZN) ZN 
   FROM dp00.T_zregdoc a left join dp00.T_ZDATA_N B on  A.cod_regdoc=B.cod_regdoc 
    WHERE   A.PERIOD_YEAR in (extract(year from sysdate) )  
            and A.C_DOC||A.C_DOC_SUB IN('J02001','F02001')   
            AND tin in (492196,698420)
            and (BITAND (flags, 16) = 0  
             AND BITAND (flags, 2048) = 0  
             AND BITAND (flags, 1048576) = 0  
             AND BITAND (flags, 134217728) = 0)  
             
     GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o 
    where o.cod_regdoc = o.max_cdrd ) o1 

       GROUP BY period_year,c_sti,tin
     ) pdv  ON spk.tin=pdv.tin     
    
----ed podat 4 gr----                                                                                                              
    LEFT join
  (SELECT C_STI, o1.tin, 
 SUM(CASE WHEN c_doc_rowc in ('^R011G11','^R012G11' ,'^R013G11' ,'^R014G11')  THEN o1.ZN ELSE 0 END ) AS zag_plosha 

 FROM 
 (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN 
 from 
 (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter, 
                                      MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin) 
                                                                   AS max_cdrd,SUM(B.ZN) ZN 
   FROM dp00.T_zregdoc a,dp00.T_ZDATA_N B 
    WHERE   A.PERIOD_YEAR in (extract(year from sysdate),extract(year from sysdate)-1 )      

            and A.C_DOC||A.C_DOC_SUB IN ('J01381','F01381')   
            and B.c_doc_rowc  in ('^R011G11','^R012G11' ,'^R013G11' ,'^R014G11'  ) 
            AND A.cod_regdoc=B.cod_regdoc  
            and (BITAND (flags, 16) = 0  
             AND BITAND (flags, 2048) = 0  
             AND BITAND (flags, 1048576) = 0  
             AND BITAND (flags, 134217728) = 0)   
             AND tin in (492196,698420)
     GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o 
    where o.cod_regdoc = o.max_cdrd ) o1 
    GROUP BY C_STI, o1.tin ) ed  ON spk.tin=ed.tin      
   LEFT join 
    (SELECT   C_STI, tin,  
  SUM(CASE WHEN c_doc_rowc in ('^R1010G3','^A1010','^A1010_3')  THEN o1.ZN ELSE 0 END ) AS BVOZnapoch,  
  SUM(CASE WHEN c_doc_rowc in ('^R1010G4','^B1010','^A1010_4')  THEN o1.ZN ELSE 0 END ) AS BVOZnakin 
 FROM  
  (select o.C_STI,o.tin,o.c_doc_rowc,o.cod_regdoc,o.PERIOD_MONTH,o.period_year,d_get,d_enter,o.ZN  
  from  
  (SELECT   A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.PERIOD_MONTH,a.period_year,d_get,d_enter,  
                                       MAX (a.cod_regdoc) OVER (PARTITION BY A.c_sti,A.tin)  
                                                                    AS max_cdrd,SUM(B.ZN) ZN  
    FROM dp00.T_zregdoc a,dp00.T_ZDATA_N B  
     WHERE   A.PERIOD_YEAR in (extract(year from sysdate),extract(year from sysdate)-1  )   
             and A.C_DOC||A.C_DOC_SUB IN('S01001','S01100','S01110','J09011','J09012','J09001')    
             and B.c_doc_rowc  in ('^R1010G3','^R1010G4','^A1010','^B1010','^A1010_3','^A1010_4' )  
              AND tin in (492196,698420) 
             AND A.cod_regdoc=B.cod_regdoc   
             and (BITAND (flags, 16) = 0   
              AND BITAND (flags, 2048) = 0   
              AND BITAND (flags, 1048576) = 0   
              AND BITAND (flags, 134217728) = 0)   
      GROUP BY  A.C_STI,a.tin,B.c_doc_rowc,a.cod_regdoc,a.period_month,a.period_year,d_get,d_enter) o  
     where o.cod_regdoc = o.max_cdrd ) o1  
     GROUP BY  C_STI, tin) oz
     ON spk.tin=oz.tin 
    
    
    ---galuz--------------------- 
    LEFT JOIN
    (SELECT kod,
    SUM(zn*DECODE(idparm,104,1,58,-1,0))                             spl_vsogo,
    SUM(zn*DECODE(idparm,104,1,58,-1,0)*decode(shot,'14010100',1,0)) spl_pdv
    FROM
    (SELECT * FROM galuz.vg306_pb  WHERE rdata IN to_date('01.07.2023','dd.mm.yyyy') 
    UNION
    SELECT * FROM galuz.vf306 WHERE rdata IN to_date('01.07.2023','dd.mm.yyyy'))
    WHERE idparm IN (104,58)
        AND kod in (492196,698420) 
    GROUP BY kod)
    
     gal ON  spk.tin=gal.kod          
    




 ORDER BY 1,2,6
    
    