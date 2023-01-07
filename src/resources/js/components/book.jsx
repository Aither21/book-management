import React from "react";
// import axios from "axios";

const Book = (props) => {
	const BookPath = `/book?bookId=${props.id}`;

	return(
		<>
		<table className="border">
			<tbody>
				<tr>
					<td className="p-1 border ">{props.id}</td>
					<td className="p-1 border">{props.name}</td>
					<td className="p-1 border">{props.author}</td>
					<td className="p-1 border">{props.company}</td>
				</tr>
			</tbody>
		</table>
		<div className="py-8 flex flex-wrap md:flex-nowrap justify-center">
			<div className="w-80 md:w-40 h-80 md:h-40 md:mb-0 mr-5 mb-6 flex-shrink-0 flex flex-col border justify-center items-center">
				<img src={props.imageUrl} width="150" height="175" />
				{/* <span className="font-semibold title-font text-gray-700">画像</span>
				<span className="mt-1 text-gray-500 text-sm">100×100</span> */}
			</div>
			<div className="md:flex-grow">
				<a href={BookPath}>
					<h2 className="text-2xl font-medium text-gray-900 title-font mb-2">{props.id}　{props.name}</h2>
				</a>
				<a className="text-indigo-500 inline-flex items-center mt-2">{props.author}
					<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" >
						<path d="M5 12h14"></path>
						<path d="M12 5l7 7-7 7"></path>
					</svg>
				</a>
				<p className="leading-relaxed">Glossier echo park pug, church-key sartorial biodiesel vexillologist pop-up snackwave ramps cornhole. Marfa 3 wolf moon party messenger bag selfies, poke vaporware kombucha lumbersexual pork belly polaroid hoodie portland craft beer.</p>
				<a className="text-indigo-500 inline-flex items-center mt-4">{props.company}
					<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" >
						<path d="M5 12h14"></path>
						<path d="M12 5l7 7-7 7"></path>
					</svg>
				</a>
			</div>
		</div>
		</>
	);
}

export {Book} ;