import React from "react";
// import axios from "axios";

const AdminBookLent = (props) => {
	const BookPath = `/book?bookId=${props.id}`;

	return(
		<div className="flex flex-wrap flex-nowrap py-2">
			<div className="w-20 md:w-21 h-20 md:h-21 md:mb-0 mr-5 mb-0 flex-shrink-0 flex flex-col border justify-center items-center pb-1">
				<span className="font-semibold title-font text-gray-700">画像</span>
				<span className="mt-1 text-gray-500 text-sm">100×100</span>
			</div>
			<div className="md:flex-grow">
				<a href={BookPath}>
					<h2 className="text-1xl font-medium text-gray-900 title-font">{props.id}　{props.name}</h2>
				</a>
				<a className="text-indigo-500 inline-flex items-center">{props.author}
					<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" >
						<path d="M5 12h14"></path>
						<path d="M12 5l7 7-7 7"></path>
					</svg>
				</a>
				<a className="text-indigo-500 inline-flex items-center">{props.company}
					<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" >
						<path d="M5 12h14"></path>
						<path d="M12 5l7 7-7 7"></path>
					</svg>
				</a>
				<div className="flex">
					<button className={`flex ml-1 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded`}>
						レンタル許可
					</button>
					<button className={`flex ml-1 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded`}>
						レンタル却下
					</button>
				</div>
			</div>
		</div>
	);
}

export {AdminBookLent};