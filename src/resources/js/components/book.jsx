import { React, useState, useEffect } from "react";
// import axios from "axios";

const Book = (props) => {
	const BookPath = `/book?bookId=${props.id}`;
	const [bookStatusColorState, setBookStatusColorState] = useState('');
	const [bookStatusState, setBookStatusState] = useState('');
	
	useEffect(() => {
		switch(props.status){
			case 1:
				setBookStatusState('貸出申請中');
				setBookStatusColorState('text-yellow-600');
				break;
			case 2:
				setBookStatusState('貸出中');
				setBookStatusColorState('text-red-500');
				break;
			case 3:
				setBookStatusState('返却申請中');
				setBookStatusColorState('text-purple-500');
				break;
			default:
				setBookStatusState('貸出可');
				setBookStatusColorState('text-green-500');
				break;
		}
	}, [props.status])
	return (
		<div>
			{/* <table className="border">
				<tbody>
					<tr>
						<td className="p-1 border ">{props.id}</td>
						<td className="p-1 border">{props.name}</td>
						<td className="p-1 border">{props.author}</td>
						<td className="p-1 border">{props.company}</td>
						<td className="p-1 border">{props.status}</td>
						<td className="p-1 border">{props.userName}</td>
					</tr>
				</tbody>
			</table> */}
			<div className="py-4 flex flex-wrap md:flex-nowrap justify-center">
				<div className="w-80 md:w-40 h-80 md:h-40 md:mb-0 mr-5 mb-6 flex-shrink-0 flex flex-col border justify-center items-center">
					<img className="h-full w-auto" src={props.imageUrl} width="150" height="175" />
					{/* <span className="font-semibold title-font text-gray-700">画像</span>
				<span className="mt-1 text-gray-500 text-sm">100×100</span> */}
				</div>
				<div className="md:flex-grow">
					<a href={BookPath}>
						<h2 className="text-2xl font-medium text-gray-900 title-font">{props.id}　{props.name}</h2>
					</a>
					<a className="inline-flex items-center mt-2">{props.author}
					</a>
						<div className="flex">
							<a className="text-indigo-500 inline-flex items-center my-1">{props.company}</a>
							<div className="pr-2 flex justify-center items-center">
								<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2" fill="none" strokeLinecap="round" strokeLinejoin="round">
									<path d="M5 12h14"></path>
									<path d="M12 5l7 7-7 7"></path>
								</svg>
							</div>
							<a className={`text-indigo-500 inline-flex items-center my-1 ${bookStatusColorState}`}>{bookStatusState}</a>
							<div className="pr-2 flex justify-center items-center">
								<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2" fill="none" strokeLinecap="round" strokeLinejoin="round">
									<path d="M5 12h14"></path>
									<path d="M12 5l7 7-7 7"></path>
								</svg>
							</div>
							<a className="text-indigo-500 inline-flex items-center my-1">{props.userName}</a>
						</div>
					<p className="leading-relaxed">Glossier echo park pug, church-key sartorial biodiesel vexillologist pop-up snackwave ramps cornhole. Marfa 3 wolf moon party messenger bag selfies, poke vaporware kombucha lumbersexual pork belly polaroid hoodie portland craft beer.</p>
				</div>
			</div>
		</div>
	);
}

export { Book };