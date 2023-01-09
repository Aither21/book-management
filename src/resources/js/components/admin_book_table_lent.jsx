import { React, useRef } from "react";
import { AdminBookLent } from './admin_book_lent';

const AdminBookTableLent = (props) => {
	const isFirstRender = useRef(true);	
	if(isFirstRender.current === true){
		return (
			<div className="border w-full my-10">
				<section className="text-gray-600 body-font overflow-hidden">
					<div className="container px-5 mx-auto">
						<div className="divide-y-2 divide-gray-100">
						{props.lists?.map((value, index) => {
							return <AdminBookLent id={value.id} name={value.name} author={value.author} company={value.company} key={index.toString()} />
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

export {AdminBookTableLent};