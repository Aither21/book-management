import { React, useState, useEffect, useRef, ReactDOM} from "react";
import axios from "axios";
import { Book } from '../components/book';

const BookTable = (props) => {
	const isFirstRender = useRef(false);
	
	useEffect(() => {
		isFirstRender.current = true;
	}, [props])
	
	if(isFirstRender.current === true){
		return (
			<div>
				<section className="text-gray-600 body-font overflow-hidden">
					<div className="container px-5 py-16 mx-auto">
						<div className="-my-8 divide-y-2 divide-gray-100">
						{props.lists?.map((value, index) => {
							return <Book 
								id={value.id} name={value.name} author={value.author} imageUrl={value.imageUrl} 
								company={value.company} status={value.status} userName={value.userName} key={index.toString()} />
						})}
						</div>
					</div>
				</section>
			</div>
		)
	}
	else {
		return(
			<div>Now Loading</div>
		);
	}
}

export {BookTable};