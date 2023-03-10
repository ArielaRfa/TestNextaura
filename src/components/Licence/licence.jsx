import React from "react";
const Licence = ({ id, label, type,date_exp,lien,total,used,contact,creatDY,creatAt }) => (
  <div className="col-12 col-lg-4 p-2 border">
    <p>{label}</p>
    <p>{type}</p>
    <p>{date_exp}</p>
    <p>{lien}</p>
    <p>{total}</p>
    <p>{used}</p>
    <p>{contact}</p>
    <p>{creatDY}</p>
    <p>{creatAt}</p>
    <p>
      <a href={`/licence/${id}`} className="btn btn-sm btn-primary">Voir la fiche</a>
    </p>
  </div>
);

export default Licence;