import { React, useRef } from "react";
import { AdminBookBorrow } from './admin_book_borrow';

const AdminBookTableBorrow = (props) => {
	const isFirstRender = useRef(true);	
	if(isFirstRender.current === true){
		return (
			<div className="border w-full">
				<section className="text-gray-600 body-font overflow-hidden">
					<div className="container px-5 mx-auto">
						<div className="divide-y-2 divide-gray-100">
						{props.lists?.map((value, index) => {
							return <AdminBookBorrow id={value.id} name={value.name} author={value.author} company={value.company} key={index.toString()} />
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

export {AdminBookTableBorrow};