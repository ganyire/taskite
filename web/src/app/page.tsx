import { Button } from "@/components/ui/button";
import Image from "next/image";

export default function Home() {
	return (
		<main className="flex min-h-screen flex-col items-center justify-between p-24">
			<Button>Click me</Button>

			<p className="bg-background text-foreground p-4 rounded">
				Leonard ganyire
			</p>
		</main>
	);
}
