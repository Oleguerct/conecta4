import React, { useEffect, useState } from 'react'

import { colorMap } from '../../constants/constants.js'

function Hole({holeState}){
    let color = colorMap[holeState] || 'null';
    return (
      <div className={`hole ${color}`}></div>
    )
  }

export default Hole