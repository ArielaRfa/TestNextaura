import React, { Component } from "react";
import Licence from "./licence";

class licenceList extends Component {
  render = () => {
    const { licences } = this.props;
    return licences.map(licence => (
      <Licence id={licence.id} label={licence.label} type={licence.type} date_exp={licence.date_exp} lien={licence.lien} total={licence.total} used={licence.used} contact={licence.contact} creatDY={licence.creatDY} creatAt={licence.creatAt} key={user.id} />
    ));
  };
}

export default licenceList;